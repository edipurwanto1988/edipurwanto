#!/bin/bash

# Laravel Blog Asset Build Script
# This script builds assets with fallback support

echo "Starting asset build process..."

# Check if Node.js and npm are installed
if ! command -v node &> /dev/null; then
    echo "Error: Node.js is not installed"
    exit 1
fi

if ! command -v npm &> /dev/null; then
    echo "Error: npm is not installed"
    exit 1
fi

# Install dependencies
echo "Installing Node.js dependencies..."
npm install

# Build Vite assets
echo "Building Vite assets..."
npm run build

# Generate fallback manifest if needed
echo "Checking for manifest file..."
MANIFEST_PATH="public/build/manifest.json"

if [ ! -f "$MANIFEST_PATH" ]; then
    echo "Generating fallback manifest..."
    cat > "$MANIFEST_PATH" << 'EOF'
{
  "resources/css/app.css": {
    "file": "assets/app.css",
    "src": "resources/css/app.css",
    "isEntry": true,
    "name": "app",
    "names": ["app.css"]
  },
  "resources/js/app.js": {
    "file": "assets/app.js",
    "src": "resources/js/app.js",
    "isEntry": true,
    "name": "app"
  }
}
EOF
fi

# Verify build
echo "Verifying build assets..."
if [ -f "$MANIFEST_PATH" ]; then
    echo "✅ Manifest file found: $MANIFEST_PATH"
else
    echo "❌ Manifest file not found"
    exit 1
fi

CSS_ASSET=$(grep -o '"file": "[^"]*\.css"' "$MANIFEST_PATH" | cut -d'"' -f4)
JS_ASSET=$(grep -o '"file": "[^"]*\.js"' "$MANIFEST_PATH" | cut -d'"' -f4)

if [ -f "public/build/$CSS_ASSET" ]; then
    echo "✅ CSS asset found: public/build/$CSS_ASSET"
else
    echo "❌ CSS asset not found"
    exit 1
fi

if [ -f "public/build/$JS_ASSET" ]; then
    echo "✅ JS asset found: public/build/$JS_ASSET"
else
    echo "❌ JS asset not found"
    exit 1
fi

echo "Asset build completed successfully!"
echo ""
echo "Files created:"
echo "- $MANIFEST_PATH"
echo "- public/build/$CSS_ASSET"
echo "- public/build/$JS_ASSET"