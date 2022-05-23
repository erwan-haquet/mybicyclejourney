#!/usr/bin/env bash

# Generate constants for output colors
function create_colors() {
  # RED=$(tput setaf 1)
  # GREEN=$(tput setaf 2)
  CYAN=$(tput setaf 6)
  RESET=$(tput sgr0)
}

# Source the .env file
function source_env() {
  echo "Sourcing .env file"
  set -o allexport
  source .env
  set +o allexport
}

# Logs into the web container
# Gives access to a prompt as the user `docker` (part of the wheel group)
function ssh_into_web_console() {
  local container_name="${COMPOSE_PROJECT_NAME}-php-1"

  echo "${CYAN}Logging into $container_name...${RESET}"
  docker exec -ti "$container_name" bash
}

create_colors
source_env
# Parses the scripts' arguments and calls the right script
# @see https://tldp.org/LDP/Bash-Beginners-Guide/html/sect_07_03.html
case "$1" in
'console')
  ssh_into_web_console
  ;;
esac
