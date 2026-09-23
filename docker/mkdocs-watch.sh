#!/bin/sh
# Surveille le dossier resources/docs et régénère la documentation statique
# mkdocs (public/assets/docs) dès qu'un changement est détecté.
#
# Ce script est destiné à être exécuté à l'intérieur du container mkdocs
# (voir docker/docker-compose.yml, service "mkdocs").

set -eu

DOCS_DIR="${DOCS_DIR:-/app/resources/docs}"
WATCH_INTERVAL="${MKDOCS_WATCH_INTERVAL:-10}"
HASH_FILE="/tmp/mkdocs-docs.sha1"

# Calcule un condensat représentant l'état courant des fichiers de
# documentation (contenu + chemins), afin de détecter tout ajout,
# suppression ou modification.
compute_hash() {
    find "$DOCS_DIR" -type f \( -name '*.md' -o -name '*.yml' -o -path '*/docs/*' \) \
        -exec sha1sum {} \; 2>/dev/null | sort | sha1sum | awk '{print $1}'
}

build() {
    echo "[mkdocs-watch] $(date -Iseconds) : génération de la documentation..."
    if mkdocs build --config-file "$DOCS_DIR/mkdocs.yml" --clean; then
        echo "[mkdocs-watch] $(date -Iseconds) : génération terminée avec succès."
    else
        echo "[mkdocs-watch] $(date -Iseconds) : échec de la génération." >&2
    fi
}

# Génération initiale au démarrage du container.
build
compute_hash > "$HASH_FILE"

while true; do
    sleep "$WATCH_INTERVAL"

    current_hash="$(compute_hash)"
    previous_hash="$(cat "$HASH_FILE" 2>/dev/null || true)"

    if [ "$current_hash" != "$previous_hash" ]; then
        build
        echo "$current_hash" > "$HASH_FILE"
    fi
done
