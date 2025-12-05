#!/bin/bash

################################################################################
# VipResponse API Driver Installation Script
# This script downloads and configures the VipResponse API driver binary
################################################################################

set -e  # Exit on error

# Color codes for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuration
CDN_URL="https://cdn.example.com/cortex-vipresponse"  # Replace with actual CDN URL
INSTALL_DIR="/var/www/cortex/microservices/networks_apis"
BINARY_NAME="cortex-vipresponse"
BINARY_PATH="${INSTALL_DIR}/${BINARY_NAME}"
SPONSOR_MODEL_PATH="/var/www/cortex/app/Models/Sponsor.php"
BACKUP_SUFFIX=".backup.$(date +%Y%m%d_%H%M%S)"

# Function to print colored messages
print_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to check if running as root or with sudo
check_privileges() {
    if [[ $EUID -ne 0 ]] && ! sudo -n true 2>/dev/null; then
        print_warning "This script may require sudo privileges for setting permissions"
    fi
}

# Function to create backup if binary exists
backup_existing() {
    if [[ -f "${BINARY_PATH}" ]]; then
        print_info "Backing up existing binary to ${BINARY_PATH}${BACKUP_SUFFIX}"
        cp "${BINARY_PATH}" "${BINARY_PATH}${BACKUP_SUFFIX}"
    fi
}

# Function to download the binary
download_binary() {
    print_info "Downloading VipResponse binary from CDN..."
    
    # Create directory if it doesn't exist
    if [[ ! -d "${INSTALL_DIR}" ]]; then
        print_info "Creating directory: ${INSTALL_DIR}"
        mkdir -p "${INSTALL_DIR}"
    fi
    
    # Download the binary
    if command -v wget &> /dev/null; then
        wget -O "${BINARY_PATH}" "${CDN_URL}" || {
            print_error "Failed to download binary using wget"
            return 1
        }
    elif command -v curl &> /dev/null; then
        curl -L -o "${BINARY_PATH}" "${CDN_URL}" || {
            print_error "Failed to download binary using curl"
            return 1
        }
    else
        print_error "Neither wget nor curl is available. Please install one of them."
        return 1
    fi
    
    print_info "Download completed successfully"
}

# Function to set permissions
set_permissions() {
    print_info "Setting permissions for ${BINARY_PATH}..."
    
    # Make the binary executable
    chmod 755 "${BINARY_PATH}" || {
        print_error "Failed to set executable permissions"
        return 1
    }
    
    # Change ownership to www-data
    if [[ $EUID -eq 0 ]]; then
        chown www-data:www-data "${BINARY_PATH}" || {
            print_error "Failed to set ownership"
            return 1
        }
    else
        sudo chown www-data:www-data "${BINARY_PATH}" || {
            print_error "Failed to set ownership (sudo required)"
            return 1
        }
    fi
    
    print_info "Permissions set successfully"
}

# Function to update Sponsor.php model
update_sponsor_model() {
    print_info "Updating Sponsor.php model..."
    
    # Check if VipResponse already exists in sponsors_templates
    if grep -q '"VipResponse"' "${SPONSOR_MODEL_PATH}"; then
        print_info "VipResponse already exists in sponsors_templates array. Skipping..."
        return 0
    fi
    
    # Create backup of Sponsor.php
    print_info "Creating backup of Sponsor.php..."
    cp "${SPONSOR_MODEL_PATH}" "${SPONSOR_MODEL_PATH}${BACKUP_SUFFIX}"
    
    # Find the last element in sponsors_templates array and add VipResponse after it
    print_info "Adding VipResponse to sponsors_templates array..."
    
    # Create the VipResponse template entry
    local vipresponse_entry='        [
            '\''id'\'' => "17",
            '\''name'\'' => "VipResponse",
            '\''auto_l_s'\'' => "none",
            '\''api_url_campaign'\'' => "https://api.viprsp.nl/api",
            '\''api_url_reporting'\'' => "https://api.viprsp.nl/api",
            '\''api_driver'\'' => "cortex-vipresponse",
            '\''login_page_link'\'' => "#none",
            '\''home_page_link'\'' => "#none",
            '\''auto_login_driver'\'' => "none",
            '\''link_template'\'' => "&sub_id1=[user]&sub_id2=[offer]-[campaign]&sub_id3=[list]-[email]-[interface]",
        ]'
    
    # Use awk to insert the new entry before the closing ];
    awk -v entry="${vipresponse_entry}" '
    /^    \];[ ]*$/ && !done {
        # Check if previous line ends with a closing bracket
        if (prev ~ /^        \]/) {
            print prev ","
            print entry
            print $0
            done=1
            next
        }
    }
    {
        if (prev != "") print prev
        prev = $0
    }
    END {
        if (prev != "") print prev
    }
    ' "${SPONSOR_MODEL_PATH}" > "${SPONSOR_MODEL_PATH}.tmp"
    
    # Check if the update was successful
    if grep -q '"VipResponse"' "${SPONSOR_MODEL_PATH}.tmp"; then
        mv "${SPONSOR_MODEL_PATH}.tmp" "${SPONSOR_MODEL_PATH}"
        print_info "Successfully added VipResponse to sponsors_templates array"
    else
        rm -f "${SPONSOR_MODEL_PATH}.tmp"
        print_error "Failed to add VipResponse to sponsors_templates array"
        print_warning "Backup available at: ${SPONSOR_MODEL_PATH}${BACKUP_SUFFIX}"
        return 1
    fi
}

# Function to verify installation
verify_installation() {
    print_info "Verifying installation..."
    
    if [[ ! -f "${BINARY_PATH}" ]]; then
        print_error "Binary file not found at ${BINARY_PATH}"
        return 1
    fi
    
    if [[ ! -x "${BINARY_PATH}" ]]; then
        print_error "Binary is not executable"
        return 1
    fi
    
    local file_size=$(stat -f%z "${BINARY_PATH}" 2>/dev/null || stat -c%s "${BINARY_PATH}" 2>/dev/null)
    if [[ ${file_size} -lt 1000 ]]; then
        print_warning "Binary file size is suspiciously small (${file_size} bytes)"
    fi
    
    print_info "Installation verified successfully"
    print_info "Binary location: ${BINARY_PATH}"
    print_info "Binary size: ${file_size} bytes"
    ls -lh "${BINARY_PATH}"
}

# Main execution
main() {
    print_info "Starting VipResponse API Driver installation..."
    print_info "================================================"
    
    check_privileges
    backup_existing
    download_binary || exit 1
    set_permissions || exit 1
    update_sponsor_model || exit 1
    verify_installation || exit 1
    
    print_info "================================================"
    print_info "VipResponse API Driver installation completed successfully!"
    print_info ""
    print_info "The VipResponse driver is now configured in:"
    print_info "  - Binary: ${BINARY_PATH}"
    print_info "  - Model: /var/www/cortex/app/Models/Sponsor.php (template ID: 17)"
    print_info ""
    print_info "You can now use VipResponse as an API driver in your sponsors."
}

# Run main function
main "$@"
