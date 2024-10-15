#!/bin/bash

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[0;33m'
BLUE='\033[0;34m'
NC='\033[0m'

REPO_FILE="available-repositories.txt"
REPOS=()

usage() {
  echo -e "${YELLOW}Usage: $0 --file-to-distribute=<path_to_file>${NC}"
  exit 1
}

if [ "$#" -eq 0 ]; then
  usage
fi

if ! git config --global user.name > /dev/null; then
  echo -e "${RED}You must be logged in to do this operation${NC}"
  exit 1
fi

select_repos() {
  if [ ! -f "$REPO_FILE" ]; then
    echo -e "${RED}The file $REPO_FILE hasn't been found. Please check if the file path is correct.${NC}"
    exit 1
  fi

  echo -e "${BLUE}Available repositories:${NC}"

  mapfile -t ALL_REPOS < "$REPO_FILE"
  for i in "${!ALL_REPOS[@]}"; do
    echo "$((i+1))) ${ALL_REPOS[$i]}"
  done

  echo -e "${YELLOW}Enter the numbers of the repositories you wish to update (separated by spaces) or 'A' to select all:${NC}"
  read -r -a SELECTED_REPOS

  if [[ " ${SELECTED_REPOS[@]} " =~ " A " ]]; then
    REPOS=("${ALL_REPOS[@]}")
  else
    for i in "${SELECTED_REPOS[@]}"; do
      if [ "$i" -ge 1 ] && [ "$i" -le "${#ALL_REPOS[@]}" ]; then
        REPOS+=("${ALL_REPOS[$((i-1))]}")
      else
        echo -e "${RED}Invalid selection: $i${NC}"
        exit 1
      fi
    done
  fi
}

while [[ "$#" -gt 0 ]]; do
  case $1 in
    --file-to-distribute=*) FILE_TO_DISTRIBUTE="${1#*=}"; shift ;;
    *) echo -e "${RED}Unknown parameter passed: $1${NC}"; usage ;;
  esac
done

if [ ! -f "$FILE_TO_DISTRIBUTE" ]; then
  echo -e "${RED}The file $FILE_TO_DISTRIBUTE hasn't been found. Please check if the file path is correct.${NC}"
  exit 1
fi

select_repos

if [ ${#REPOS[@]} -eq 0 ]; then
  echo -e "${RED}No repositories selected.${NC}"
  exit 1
fi

for REPO in "${REPOS[@]}"; do
  echo -e "${BLUE}Cloning $REPO...${NC}"
  
  REPO_NAME=$(basename "$REPO" .git)

  if [ ! -d "$REPO_NAME" ]; then
    git clone "$REPO"
  fi
  
  cd "$REPO_NAME" || { echo -e "${RED}Can't access: $REPO${NC}"; exit 1; }

  echo -e "${BLUE}Switching to base branch${NC}"
  
  git checkout development

  echo -e "${BLUE}Creating a new branch for the updates${NC}"
  BRANCH_NAME="update-semgrep-config-$(date +%Y%m%d)"
  git checkout -b "$BRANCH_NAME"

  if [ ! -d ".github/workflows" ]; then
    mkdir -p .github/workflows
  fi

  cp "../$FILE_TO_DISTRIBUTE" .github/workflows/

  git add .

  echo -e "${BLUE}Committing the changes${NC}"
  git commit -m "Updating semgrep configuration"

  echo -e "${BLUE}Pushing to origin: $BRANCH_NAME${NC}"
  git push --set-upstream origin "$BRANCH_NAME"

  cd ..
done

echo -e "${GREEN}Operation completed successfully!${NC}"
