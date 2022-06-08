#!/usr/bin/env bash

SSL_DIR="./docker/dev/nginx/ssl"
MKCERT_DOWNLOAD_LINK="https://github.com/FiloSottile/mkcert/releases/download/v1.4.2/mkcert-v1.4.2-linux-amd64"
MKCERT_EXECUTABLE="./mkcert-v1.4.2-linux-amd64"
DOMAINS="mybicyclejourney.tld www.mybicyclejourney.tld"
CERT_FILE="web.pem"
KEY_FILE="web-key.pem"

function create_colors() {
  MAGENTA=$(tput setaf 5)
  GREEN=$(tput setaf 2)
  CYAN=$(tput setaf 6)
  RESET=$(tput sgr0)
}

function move_to_working_directory() {
  echo "${CYAN}Setting up working directory${RESET}"
  cd "${SSL_DIR}" || exit
}

function clean_up_working_directory() {
  echo "${CYAN}Cleaning up working directory${RESET}"
  rm -f "${MKCERT_EXECUTABLE}"
}

function setup_mkcert() {
  echo "${CYAN}Installing mkcert's dependencies${RESET}"
  sudo apt install libnss3-tools

  echo "${CYAN}Installing mkcert${RESET}"
  wget "${MKCERT_DOWNLOAD_LINK}"
  chmod +x "${MKCERT_EXECUTABLE}"
}

function install_root_certificate() {
  echo "${CYAN}Installing a local root certificate${RESET}"
  eval "${MKCERT_EXECUTABLE} --install"
}

function generate_domain_certificate() {
  echo "${CYAN}Generating a self-signed certificate${RESET}"
  eval "${MKCERT_EXECUTABLE} -cert-file ${CERT_FILE} -key-file ${KEY_FILE} ${DOMAINS}"
}

function convert_root_certificate_to_crt() {
  echo "${CYAN}Copying the root certificate${RESET}"
  ROOT_CERT_PATH="$(eval ${MKCERT_EXECUTABLE} -CAROOT)/rootCA.pem"
  cp "${ROOT_CERT_PATH}" ./rootCA.pem
  openssl x509 -outform der -in ./rootCA.pem -out ./rootCA.crt
}

function finalize() {
  echo "${GREEN}Installation done ! You can now build the containers and start the app${RESET}"
}

## Main ##
create_colors
move_to_working_directory
setup_mkcert
install_root_certificate
generate_domain_certificate
convert_root_certificate_to_crt
clean_up_working_directory
finalize
