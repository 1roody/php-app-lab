#!/bin/bash

if ! git config --global user.name > /dev/null; then
  echo "You must be logged in at github to use this operation"
  exit 1
fi

# Change this
FILE_TO_DISTRIBUTE="../config/semgrep.yml"

if [ ! -f "$FILE_TO_DISTRIBUTE" ]; then
  echo "The file $FILE_TO_DISTRIBUTE hasn't been found, please check if file path is correct"
  exit 1
fi

# Change this
REPOSITORIES=("https://github.com/1roody/php-app-lab")

for REPO in "${REPOSITORIES[@]}"; do
  echo "Cloning $REPO..."
  
  REPO_NAME=$(basename "$REPO" .git)

  if [ ! -d "$REPO_NAME" ]; then
    git clone "$REPO"
  fi
  
  cd "$REPO_NAME" || { echo "Can't access: $REPO"; exit 1; }

  echo "changing to branch: development"
  git checkout "development"

  echo "Creating a new branch to the updates"
  BRANCH_NAME="branch-teste-script"
  git checkout -b "$BRANCH_NAME"

  if [ ! -d ".github/workflows" ]; then
    mkdir -p .github/workflows
  fi
  
  cp "../$FILE_TO_DISTRIBUTE" .github/workflows/

  git add .

  git commit -m "Updating Semgrep Setup"

  if git ls-remote --exit-code --heads origin "$BRANCH_NAME" > /dev/null; then
    echo "Pushing updates to existing branch $BRANCH_NAME"
    git push
  else
    echo "Branch $BRANCH_NAME does not exist in the remote. Setting upstream and pushing updates..."
    git push --set-upstream origin "$BRANCH_NAME"
  fi

done

echo "Script Sucessfully Completed!"