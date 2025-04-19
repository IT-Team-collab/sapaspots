#!/bin/bash

# Update favicon.ico to favicon.svg in all HTML files
find . -name "*.html" -type f -exec sed -i 's/<link rel="icon" href="favicon.ico">/<link rel="icon" href="favicon.svg" type="image\/svg+xml">/g' {} \;

echo "Updated favicon in all HTML files" 