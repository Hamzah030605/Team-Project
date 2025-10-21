#!/usr/bin/env bash
set -euo pipefail

# Run this script from the project root as: ./backend/run.sh
# It will create a virtualenv at backend/.venv, install backend/requirements.txt, and run the server.

cd "$(dirname "$0")"

if [ ! -d ".venv" ]; then
  echo "Creating virtualenv in backend/.venv..."
  python3 -m venv .venv
fi

# Activate venv
# shellcheck disable=SC1091
. .venv/bin/activate

# Install requirements (no-op if already installed)
python3 -m pip install --upgrade pip
python3 -m pip install -r requirements.txt

# Allow overriding PORT externally (default 5000)
PORT=${PORT:-5000}

echo "Starting backend on port $PORT (use CTRL+C to stop)"
exec python3 app.py

