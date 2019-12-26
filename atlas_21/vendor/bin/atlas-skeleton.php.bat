@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../atlas/cli/bin/atlas-skeleton.php
php "%BIN_TARGET%" %*
