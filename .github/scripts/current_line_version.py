import sys
import xml.etree.ElementTree as ET

# Print the version currently published in update.xml for the release line
# (major version) of the given version. Prints nothing if that line has no
# block yet. Used by the workflow to decide whether a new release is needed.


def current_line_version(version):
    major = version.split('.')[0]
    root = ET.parse('update.xml').getroot()

    for update in root.findall('update'):
        current = (update.findtext('version') or '').strip()
        if current.split('.')[0] == major:
            print(current)
            return

    print('')


if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: current_line_version.py <version>")
        sys.exit(1)

    current_line_version(sys.argv[1])
