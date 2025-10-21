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
- I've added your team members as collaborators on GitHub. To get the project:

```bash
# clone the repo
git clone git@github.com:Hamzah030605/Team-Project.git
cd Team-Project
```

- Branching: create feature branches for work, e.g. `git checkout -b feat/add-tests`.
- Commit messages: short subject line, optional longer body. Example:
  `git commit -m "feat: add user login UI" -m "Adds login form and client-side validation"`

- Run tests (if added) and ensure linting passes before pushing PRs.

License
-------
This project is MIT licensed. See `LICENSE`.
