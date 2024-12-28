#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

echo "Starting asset reorganization..."

# Base directories
THEME_DIR="$(pwd)"
ASSETS_DIR="$THEME_DIR/assets"
FEATURES_DIR="$THEME_DIR/features"

# Function to create feature asset structure
create_feature_structure() {
    local feature=$1
    local feature_dir="$FEATURES_DIR/$feature"
    
    mkdir -p "$feature_dir/assets/js"
    mkdir -p "$feature_dir/assets/scss"
    mkdir -p "$feature_dir/assets/types"
    mkdir -p "$feature_dir/components"
    
    echo -e "${GREEN}Created directory structure for $feature${NC}"
}

# Function to move feature-specific assets
move_feature_assets() {
    local feature=$1
    local src_dir="$ASSETS_DIR/dashboard/features/$feature"
    local dest_dir="$FEATURES_DIR/$feature/assets"
    
    if [ -d "$src_dir" ]; then
        echo -e "${YELLOW}Moving $feature assets...${NC}"
        
        # Move TypeScript files
        find "$src_dir" -name "*.ts" -o -name "*.tsx" | while read -r file; do
            mkdir -p "$dest_dir/js"
            cp "$file" "$dest_dir/js/"
            echo "Moved: $file -> $dest_dir/js/"
        done
        
        # Move SCSS files
        find "$src_dir" -name "*.scss" | while read -r file; do
            mkdir -p "$dest_dir/scss"
            cp "$file" "$dest_dir/scss/"
            echo "Moved: $file -> $dest_dir/scss/"
        done
        
        # Move type definitions
        find "$src_dir" -name "*.d.ts" | while read -r file; do
            mkdir -p "$dest_dir/types"
            cp "$file" "$dest_dir/types/"
            echo "Moved: $file -> $dest_dir/types/"
        done
    fi
}

# Create feature structures
for feature in profile workout training-persona; do
    create_feature_structure "$feature"
    move_feature_assets "$feature"
done

# Move core components
echo -e "${YELLOW}Moving core components...${NC}"
mkdir -p "$THEME_DIR/dashboard/components"
cp -r "$ASSETS_DIR/dashboard/components/"* "$THEME_DIR/dashboard/components/"

# Move core types
echo -e "${YELLOW}Moving core types...${NC}"
mkdir -p "$THEME_DIR/dashboard/types"
cp -r "$ASSETS_DIR/dashboard/types/"* "$THEME_DIR/dashboard/types/"

# Move core events
echo -e "${YELLOW}Moving core events...${NC}"
cp "$ASSETS_DIR/dashboard/events.ts" "$THEME_DIR/dashboard/"

# Clean up legacy directories
echo -e "${YELLOW}Cleaning up legacy directories...${NC}"
directories_to_remove=(
    "$ASSETS_DIR/src/dashboard/scss"
    "$ASSETS_DIR/dashboard/features"
)

for dir in "${directories_to_remove[@]}"; do
    if [ -d "$dir" ]; then
        echo "Removing: $dir"
        rm -rf "$dir"
    fi
done

echo -e "${GREEN}Asset reorganization complete!${NC}"
echo "Please verify the changes and update import paths in TypeScript files." 