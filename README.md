# Simple Flask + Static Frontend App

Project structure:

- `backend/` - Flask backend (serves API and static frontend files)
- `frontend/` - Static frontend files (HTML, CSS, JS)
- `requirements.txt` - Python dependencies

Quick start (macOS / Linux):

```bash
python3 -m venv .venv
source .venv/bin/activate
python3 -m pip install -r requirements.txt
python3 backend/app.py
```

Open http://localhost:5000 in your browser.

Notes:
- The backend serves API routes under `/api/*` and the static frontend from the `frontend/` folder.
- Data is stored in memory (the `items` list) and will reset when the server restarts.

