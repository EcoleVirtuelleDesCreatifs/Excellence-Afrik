<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvel article soumis</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #ffffff;
            padding: 30px;
            border: 1px solid #e1e5e9;
            border-top: none;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border: 1px solid #e1e5e9;
            border-top: none;
            border-radius: 0 0 10px 10px;
            font-size: 14px;
            color: #6c757d;
        }
        .article-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 15px 0;
            font-weight: 600;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📝 Nouvel article soumis</h1>
        <p>Excellence Afrik - Système de gestion éditoriale</p>
    </div>
    
    <div class="content">
        <h2>Bonjour,</h2>
        
        <p>Un nouvel article a été soumis pour validation et attend votre révision.</p>
        
        <div class="article-info">
            <h3>📄 Détails de l'article :</h3>
            <p><strong>Titre :</strong> {{ $article->title }}</p>
            <p><strong>Auteur :</strong> {{ $author->name }} ({{ $author->email }})</p>
            <p><strong>Catégorie :</strong> {{ $article->category->name ?? 'Non spécifiée' }}</p>
            <p><strong>Date de soumission :</strong> {{ $article->updated_at->format('d/m/Y à H:i') }}</p>
            @if($article->excerpt)
                <p><strong>Extrait :</strong> {{ Str::limit($article->excerpt, 200) }}</p>
            @endif
        </div>
        
        <div class="alert">
            <strong>📋 Action requise :</strong> Cet article est maintenant en attente de validation. 
            Veuillez le réviser et décider de sa publication ou demander des modifications.
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $dashboardUrl }}" class="btn">
                👀 Réviser l'article
            </a>
        </div>
        
        <p>Vous pouvez accéder à l'article directement depuis votre tableau de bord pour :</p>
        <ul>
            <li>📖 Lire le contenu complet</li>
            <li>✏️ Apporter des modifications si nécessaire</li>
            <li>✅ Approuver et publier</li>
            <li>📝 Demander des révisions</li>
        </ul>
    </div>
    
    <div class="footer">
        <p><strong>Excellence Afrik</strong> - Plateforme de gestion éditoriale</p>
        <p>Cet email a été envoyé automatiquement. Ne pas répondre à cet email.</p>
    </div>
</body>
</html>