# Image Uploads Directory

This directory stores all images uploaded through the admin panel.

## Supported Formats
- JPEG (`.jpg`, `.jpeg`)
- PNG (`.png`)
- GIF (`.gif`)
- WebP (`.webp`)

## File Size Limit
Maximum file size: **5MB**

## Upload Features
- Automatic validation of file types
- Unique filename generation to prevent overwrites
- Files are named with format: `{originalname}_{timestamp}_{uniqueid}.{ext}`

## Permissions
Ensure this directory has write permissions (0755) for the web server user.

## Security
- Only image MIME types are accepted
- File extensions are validated
- Server-side validation prevents malicious uploads

## Usage
Upload images through the admin panel:
1. Navigate to any content section (Home, Diensten, Over Ons, Contact)
2. Find the image field you want to update
3. Use the "📤 Of upload een nieuwe..." file input
4. Select your image file
5. Save the form

The uploaded image path will automatically be saved to the content.
