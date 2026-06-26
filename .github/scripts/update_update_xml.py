import sys
import xml.etree.ElementTree as ET

UPDATE_XML = 'update.xml'

# Canonical, per-major metadata for each release line.
LINES = {
    '4': {
        'description': 'Module to display the last site modification date, based on the article (create/modified) dates in your site',
        'php_minimum': '7.0.0',
        'targetplatform': r'4\.[0-4]',
    },
    '5': {
        'description': 'Module to display the last site modification date, based on the article (create/modified/published) dates in your site',
        'php_minimum': '8.1.0',
        # Joomla 5.0-5.4 and all of the Joomla 6 series (not Joomla 4).
        'targetplatform': r'(5\.[0-4]|6\.[0-9]+)',
    },
}

INFOURL = 'https://github.com/pe7er/mod_db8sitelastmodified'
INFOURL_TITLE = 'mod_db8sitelastmodified'
ELEMENT = 'mod_db8sitelastmodified'
MAINTAINER = 'Peter Martin'
MAINTAINER_URL = 'https://db8.nl'


def set_child(parent, tag, text):
    """Find a direct child by tag (creating it if missing) and set its text."""
    el = parent.find(tag)
    if el is None:
        el = ET.SubElement(parent, tag)
    el.text = text
    return el


def write_block(u, version, download_url, sha512):
    """Populate an <update> element with the data for the given version."""
    line = LINES[version.split('.')[0]]

    set_child(u, 'name', 'mod_db8sitelastmodified ' + version)
    set_child(u, 'description', line['description'])
    set_child(u, 'element', ELEMENT)
    set_child(u, 'type', 'module')
    set_child(u, 'client', 'site')
    set_child(u, 'version', version)

    infourl = set_child(u, 'infourl', INFOURL)
    infourl.set('title', INFOURL_TITLE)

    downloads = u.find('downloads')
    if downloads is None:
        downloads = ET.SubElement(u, 'downloads')
    downloadurl = downloads.find('downloadurl')
    if downloadurl is None:
        downloadurl = ET.SubElement(downloads, 'downloadurl')
    downloadurl.set('type', 'full')
    downloadurl.set('format', 'zip')
    downloadurl.text = download_url

    set_child(u, 'sha512', sha512)

    tags = u.find('tags')
    if tags is None:
        tags = ET.SubElement(u, 'tags')
    if tags.find('tag') is None:
        ET.SubElement(tags, 'tag').text = 'stable'

    set_child(u, 'maintainer', MAINTAINER)
    set_child(u, 'maintainerurl', MAINTAINER_URL)
    set_child(u, 'php_minimum', line['php_minimum'])

    targetplatform = u.find('targetplatform')
    if targetplatform is None:
        targetplatform = ET.SubElement(u, 'targetplatform')
    targetplatform.set('name', 'joomla')
    targetplatform.set('version', line['targetplatform'])


def update_update_xml(version, download_url, sha512):
    major = version.split('.')[0]
    if major not in LINES:
        sys.exit('Unsupported major version: ' + major)

    tree = ET.parse(UPDATE_XML)
    root = tree.getroot()

    # Find the <update> block that belongs to this release line (same major).
    target = None
    for update in root.findall('update'):
        current = (update.findtext('version') or '').strip()
        if current.split('.')[0] == major:
            target = update
            break

    if target is None:
        # First release of this line: create a new block at the top (newest first).
        target = ET.Element('update')
        root.insert(0, target)

    write_block(target, version, download_url, sha512)

    ET.indent(tree, space='    ')
    with open(UPDATE_XML, 'w', encoding='utf-8') as handle:
        handle.write(ET.tostring(root, encoding='unicode') + '\n')


if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Usage: update_update_xml.py <version> <download_url> <sha512>")
        sys.exit(1)

    update_update_xml(sys.argv[1], sys.argv[2], sys.argv[3])
