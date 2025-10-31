<?php
require_once '../functions.php';
requireAdmin();

$content = loadContent();
$saved = false;
$error = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $newContent = json_decode($_POST['content'], true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            if (saveContent($newContent)) {
                $saved = true;
                $content = $newContent;
            } else {
                $error = 'Kon het bestand niet opslaan';
            }
        } else {
            $error = 'Ongeldige JSON: ' . json_last_error_msg();
        }
    } catch (Exception $e) {
        $error = 'Fout: ' . $e->getMessage();
    }
}

$contentJson = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Het Parket Gilde</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            background: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .admin-header {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .admin-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            transition: background 0.3s;
        }
        .admin-nav a:hover {
            background: rgba(255,255,255,0.2);
        }
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .admin-panel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .editor-container {
            position: relative;
        }
        #content-editor {
            width: 100%;
            min-height: 600px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .form-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #1976D2;
            font-size: 18px;
        }
        .info-box ul {
            margin: 10px 0 0 20px;
        }
        .info-box li {
            margin: 8px 0;
            line-height: 1.6;
        }
        .editor-tabs {
            display: flex;
            gap: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
        }
        .editor-tab {
            padding: 12px 24px;
            cursor: pointer;
            border: none;
            background: #f5f5f5;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all 0.3s;
            font-size: 15px;
            font-weight: 500;
        }
        .editor-tab.active {
            background: white;
            border-bottom-color: #667eea;
            color: #667eea;
        }
        .editor-tab:hover:not(.active) {
            background: #e8e8e8;
        }
        .tab-view {
            display: none;
        }
        .tab-view.active {
            display: block;
        }
        .editor-toolbar {
            background: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 4px 4px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .toolbar-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .toolbar-section label {
            font-weight: 500;
            color: #555;
        }
        .toolbar-section select {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
            cursor: pointer;
        }
        .toolbar-section span {
            color: #666;
            font-size: 14px;
            padding: 6px 12px;
            background: white;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }
        .json-structure {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
        }
        .json-structure h3 {
            margin-top: 0;
            color: #333;
        }
        .structure-info {
            background: white;
            padding: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .structure-info ul {
            margin: 15px 0 0 20px;
        }
        .structure-info li {
            margin: 12px 0;
            line-height: 1.6;
        }
        .structure-info strong {
            color: #667eea;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Admin Panel - Het Parket Gilde</h1>
            <nav class="admin-nav">
                <a href="/">Website bekijken</a>
                <a href="/admin/logout.php">Uitloggen</a>
            </nav>
        </div>
    </header>
    
    <div class="admin-container">
        <div class="admin-panel">
            <?php if ($saved): ?>
                <div class="message success">
                    <strong>Succes!</strong> Content is succesvol opgeslagen.
                </div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="message error">
                    <strong>Error:</strong> <?php echo h($error); ?>
                </div>
            <?php endif; ?>
            
            <div class="info-box">
                <h3>Instructies</h3>
                <p>Bewerk de JSON content hieronder. Zorg ervoor dat de JSON geldig is voordat je opslaat.</p>
                <ul>
                    <li>Gebruik dubbele quotes (") voor strings</li>
                    <li>Vergeet geen komma's tussen items</li>
                    <li>Test de JSON syntax met de "Valideer JSON" knop voordat je opslaat</li>
                    <li>Maak een backup voordat je grote wijzigingen maakt</li>
                    <li>Klik op de tabs hieronder om snel naar een specifieke sectie te navigeren</li>
                </ul>
            </div>
            
            <div class="editor-tabs">
                <button class="editor-tab active" onclick="switchTab('edit')">Content Bewerken</button>
                <button class="editor-tab" onclick="switchTab('preview')">JSON Structuur</button>
            </div>
            
            <div id="edit-view" class="tab-view active">
                <form method="POST" id="content-form">
                    <div class="editor-toolbar">
                        <div class="toolbar-section">
                            <label for="section-select">Sectie:</label>
                            <select id="section-select" onchange="jumpToSection()">
                                <option value="">Selecteer een sectie...</option>
                                <option value="site">Site Informatie</option>
                                <option value="home">Home Pagina</option>
                                <option value="diensten">Onze Diensten</option>
                                <option value="over_ons">Over Ons</option>
                                <option value="contact">Contact</option>
                            </select>
                        </div>
                        <div class="toolbar-section">
                            <span id="line-info">Regel: 1</span>
                            <span id="char-count">0 karakters</span>
                        </div>
                    </div>
                    
                    <div class="editor-container">
                        <textarea id="content-editor" name="content"><?php echo h($contentJson); ?></textarea>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                        <button type="button" class="btn btn-secondary" onclick="validateJSON()">Valideer JSON</button>
                        <button type="button" class="btn btn-secondary" onclick="formatJSON()">Formatteer</button>
                        <button type="button" class="btn btn-secondary" onclick="location.reload()">Reset</button>
                    </div>
                </form>
            </div>
            
            <div id="preview-view" class="tab-view">
                <div class="json-structure">
                    <h3>JSON Structuur Overzicht</h3>
                    <div class="structure-info">
                        <p>De content is opgedeeld in de volgende hoofdsecties:</p>
                        <ul>
                            <li><strong>site</strong> - Algemene website informatie (titel, contactgegevens)</li>
                            <li><strong>home</strong> - Home pagina content (hero, intro, vakmanschap)</li>
                            <li><strong>diensten</strong> - Onze Diensten pagina (services lijst)</li>
                            <li><strong>over_ons</strong> - Over Ons pagina (verhaal, oprichter, waarden)</li>
                            <li><strong>contact</strong> - Contact pagina (contactgegevens, openingstijden)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Tab switching
        function switchTab(tabName) {
            document.querySelectorAll('.editor-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelectorAll('.tab-view').forEach(view => {
                view.classList.remove('active');
            });
            
            event.target.classList.add('active');
            document.getElementById(tabName + '-view').classList.add('active');
        }
        
        // JSON validation
        function validateJSON() {
            const editor = document.getElementById('content-editor');
            try {
                JSON.parse(editor.value);
                alert('Succes! JSON is geldig en kan worden opgeslagen.');
            } catch (e) {
                alert('JSON Fout gevonden:\n\n' + e.message + '\n\nControleer de syntax en probeer opnieuw.');
            }
        }
        
        // JSON formatting
        function formatJSON() {
            const editor = document.getElementById('content-editor');
            try {
                const obj = JSON.parse(editor.value);
                editor.value = JSON.stringify(obj, null, 2);
                updateEditorInfo();
                alert('JSON is succesvol geformatteerd!');
            } catch (e) {
                alert('Kan JSON niet formatteren:\n\n' + e.message + '\n\nLos eerst de syntax fouten op.');
            }
        }
        
        // Jump to section
        function jumpToSection() {
            const select = document.getElementById('section-select');
            const section = select.value;
            const editor = document.getElementById('content-editor');
            
            if (section && section !== '') {
                const content = editor.value;
                const searchString = '"' + section + '"';
                const sectionIndex = content.indexOf(searchString);
                
                if (sectionIndex !== -1) {
                    editor.focus();
                    editor.setSelectionRange(sectionIndex, sectionIndex + searchString.length);
                    
                    // Calculate scroll position
                    const lines = content.substring(0, sectionIndex).split('\n').length;
                    const lineHeight = 20; // Approximate line height
                    editor.scrollTop = lines * lineHeight - 100;
                }
            }
        }
        
        // Update editor info
        function updateEditorInfo() {
            const editor = document.getElementById('content-editor');
            const content = editor.value;
            const cursorPosition = editor.selectionStart;
            const textBeforeCursor = content.substring(0, cursorPosition);
            const currentLine = textBeforeCursor.split('\n').length;
            
            document.getElementById('line-info').textContent = 'Regel: ' + currentLine;
            document.getElementById('char-count').textContent = content.length + ' karakters';
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('content-editor');
            
            // Update info on load
            updateEditorInfo();
            
            // Update info on change
            editor.addEventListener('input', updateEditorInfo);
            editor.addEventListener('click', updateEditorInfo);
            editor.addEventListener('keyup', updateEditorInfo);
            
            // Warn before leaving with unsaved changes
            let originalContent = editor.value;
            window.addEventListener('beforeunload', function (e) {
                const currentContent = editor.value;
                if (currentContent !== originalContent) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            
            // Reset original content after save
            document.getElementById('content-form').addEventListener('submit', function() {
                originalContent = editor.value;
            });
        });
    </script>
</body>
</html>
