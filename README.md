# Simple Flask + Static Frontend App

Project structure:

- `backend/` - Flask backend (serves API and static frontend files)
- `frontend/` - Static frontend files (HTML, CSS, JS)
- `requirements.txt` - points to `backend/requirements.txt`

Quick start (macOS / Linux):

```bash
# from project root
cd backend
./run.sh          # creates backend/.venv if needed and runs the app on PORT (default 5000)
# or manually:
# python3 -m venv .venv
# source .venv/bin/activate
# python3 -m pip install -r requirements.txt
# PORT=5001 python3 app.py
```

Open http://localhost:5000 in your browser.

Notes:
- The backend serves API routes under `/api/*` and the static frontend from the `frontend/` folder.
- Data is stored in memory (the `items` list) and will reset when the server restarts.

Collaborating
-------------
1. Accept the collaborator's invite.
2. Clone the repo: `git clone https://github.com/Hamzah030605/Team-Project.git`
3. Pull the latest changes: `git pull origin main`
4. Create a new branch: `git checkout -b feature-branch-name`
5. Make edits and commit:  
   ```bash
   git add .
   git commit -m "Description of your change"

License
-------
This project is MIT licensed. See `LICENSE`.
