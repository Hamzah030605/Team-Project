#!/usr/bin/env bash
set -euo pipefail

# Helper script to create the GitHub repo and push using GitHub CLI (gh).
# Usage: ./scripts/push_with_gh.sh
# Requirements: gh installed and you must be authenticated (gh auth login)

if ! command -v gh >/dev/null 2>&1; then
  echo "Error: gh (GitHub CLI) is not installed. Install with: brew install gh"
  exit 2
fi

# Ensure the user is authenticated. If not, run interactive login.
if ! gh auth status >/dev/null 2>&1; then
  echo "You are not authenticated with gh. Running 'gh auth login' now..."
  gh auth login
fi

REPO="Hamzah030605/Team-Project"

# Create repo if it doesn't exist, set origin, and push the current branch
echo "Creating repository (if needed) and pushing..."
gh repo create "$REPO" --public --source=. --remote=origin --push --confirm

echo "Done. If the command succeeded, visit: https://github.com/$REPO"
