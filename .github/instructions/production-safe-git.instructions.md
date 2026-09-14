---
description: Apply when staging, committing, merging, or pushing changes for production.
---

# Production-safe Git changes

- Before staging, inspect the worktree and review the staged diff.
- Commit only source code, configuration, migrations, assets, tests, and documentation required by the application or deployment.
- Never commit generated audit output, local session artifacts, caches, logs, temporary files, IDE metadata, local environment files, credentials, or other files not used by production.
- Keep unrelated untracked artifacts out of commits even when they exist in the worktree. For example, `graphify-out/` is an audit artifact and must remain untracked unless explicitly requested.
- When merging or releasing, verify the target branch, remote commit, and final staged/working-tree status before pushing.
