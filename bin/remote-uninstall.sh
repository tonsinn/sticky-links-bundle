#!/usr/bin/env bash
# Entfernt das Bundle vom Remote-Testserver.
#
# WICHTIG: Vorher im Backend alle Elemente der Typen sticky_links und sticky_links_item sowie Module vom Typ sticky_links
# löschen, sonst meldet die Artikelansicht einen unbekannten Elementtyp:
#   DELETE FROM tl_content WHERE type IN ('sticky_links','sticky_links_item');
#   DELETE FROM tl_module WHERE type = 'sticky_links';
set -euo pipefail

HERE="$(cd "$(dirname "$0")/.." && pwd)"
ENV_FILE="${HERE}/testinstall.env"

[ -f "${ENV_FILE}" ] || { echo "testinstall.env fehlt"; exit 1; }
set -a; . "${ENV_FILE}"; set +a

PORT="${REMOTE_PORT:-22}"
TARGET="${REMOTE_USER}@${REMOTE_HOST}"
PHPBIN="${REMOTE_PHP:-keyhelp-php85}"
COMPOSER="${REMOTE_COMPOSER:-composer}"

if [ -n "${REMOTE_KEY:-}" ]; then
  RSH="ssh -i ${REMOTE_KEY} -p ${PORT} -o StrictHostKeyChecking=accept-new"
else
  export SSHPASS="${REMOTE_PASSWORD}"
  RSH="sshpass -e ssh -p ${PORT} -o StrictHostKeyChecking=accept-new"
fi

${RSH} "${TARGET}" "export P='${REMOTE_PATH}' PHPBIN='${PHPBIN}' CMP='${COMPOSER}'; bash -s" <<'REMOTE'
set -e
cd "$P"
COMPOSER_BIN="$(command -v "$CMP" || echo "$CMP")"

"$PHPBIN" "$COMPOSER_BIN" remove tonsinn/sticky-links-bundle --no-interaction --no-progress || true
"$PHPBIN" "$COMPOSER_BIN" config --unset repositories.stickylinks || true
"$PHPBIN" vendor/bin/contao-console cache:clear

echo
echo "Verwaiste Spalten (stickyLinks…) werden nur mit --with-deletes entfernt."
echo "Dry-Run – bitte prüfen, was gelöscht würde:"
"$PHPBIN" vendor/bin/contao-console contao:migrate --dry-run
REMOTE

cat <<HINT

Wenn der Dry-Run ausschließlich stickyLinks…-Spalten zeigt, kann aufgeräumt werden:

  ${RSH} ${TARGET} "cd '${REMOTE_PATH}' && ${PHPBIN} vendor/bin/contao-console contao:migrate --with-deletes --no-interaction && rm -rf bundles/sticky-links-bundle"

ACHTUNG: --with-deletes entfernt ALLE verwaisten Spalten und Tabellen, nicht nur unsere.
HINT
