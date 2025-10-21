# Contributing

Anyone who wants to push and commit code they have edited, it's important to follow these instructions!
- Create a topic branch for any work: `git checkout -b feat/your-feature`.
- Make small, focused commits and write clear commit messages - explaining what change was made.
- Open a Pull Request against `main` when your feature is ready for review.
- Add tests for new behaviour where appropriate.
- Run the backend locally before creating a PR:

```bash
cd backend
./run.sh
# or: python3 -m venv .venv && source .venv/bin/activate && python3 -m pip install -r requirements.txt
```

- Run linters/tests locally (if added) and ensure CI passes before merging.
- Label your PR with the purpose (feature, fix, docs, chore).

If you're new to GitHub or this project, ask in the team chat and one of the maintainers will help.

