# AGENTS.md — SkyWeb Permanent Safety Rules

## Project Root Verification

**Active project root is exactly: `C:\xamp\htdocs\sky`**

Every task must verify this path before reading, searching, creating, editing, deleting, or executing any project files.

## Verification Protocol

Before performing any file operation, run this check:

```powershell
Test-Path "C:\xamp\htdocs\sky\index.php"
```

If the check returns `False`, **stop immediately** without modifying anything and report the error.

## Forbidden Paths

The following paths must **never** be used as the active project root:

- `C:\xamp\browsertest\sky`
- `C:\xamp\eht\sky`
- `C:\xamp2\docs\sky`
- `C:\xamp\sky`
- `C:\xamp\docs\sky`
- `C:\xamp\docs\sky_restore`
- Any other alternative or backup path

## Path Confirmation Rule

Only `C:\xamp\htdocs\sky` is the official project root. All file references, searches, edits, and executions must use this path exclusively.

## If Path Cannot Be Verified

If the correct path cannot be verified, stop immediately without modifying anything. Do not attempt to create, edit, or delete files in alternative locations.

## Existing Instructions

All existing project instructions and functionality are preserved. This file adds safety rules on top of existing configuration without removing any prior instructions.

## Session Start Rule

When the user writes **«sky»**, read `SKY_START_HERE.md` first (project root) and continue from the state described there. Use `DEV-HANDOFF.md` for the full change history.

## Duplicate Command Rule

If the user gives the same command twice: point it out to the user and **do not execute the duplicate** — cancel it, unless the user explicitly asks to run it again.
