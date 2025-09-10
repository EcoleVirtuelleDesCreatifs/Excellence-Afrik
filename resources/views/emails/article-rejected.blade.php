<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article nécessite des révisions</title>
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
            background: linear-gradient(135deg, #ff7675 0%, #fd79a8 100%);
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
        .feedback {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .encouragement {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            color: #0c5460;
        }
        .tips {
            background: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📋 Révisions nécessaires</h1>
        <p>Excellence Afrik - Retour éditorial</p>
    </div>
    
    <div class="content">
        <h2>Bonjour {{ $author->name }},</h2>
        
        <p>Merci pour votre soumission ! Après révision, votre article nécessite quelques ajustements avant publication.</p>
        
        <div class="article-info">
            <h3>📄 Article concerné :</h3>
            <p><strong>Titre :</strong> {{ $article->title }}</p>
            <p><strong>Catégorie :</strong> {{ $article->category->name ?? 'Non spécifiée' }}</p>
            <p><strong>Date de révision :</strong> {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
        
        @if($reason)
            <div class="feedback">
                <h3>💭 Commentaires éditoriaux :</h3>
                <p>{{ $reason }}</p>
            </div>
        @endif
        
        <div class="encouragement">
            <h3>💪 Ne vous découragez pas !</h3>
            <p>Votre travail est apprécié et nous voyons le potentiel de cet article. Les révisions font partie du processus éditorial normal et permettent d'améliorer la qualité du contenu.</p>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $dashboardUrl }}" class="btn">
                ✏️ Réviser l'article
            </a>
        </div>
        
        <h3>📝 Points à vérifier généralement :</h3>
        
        <div class="tips">
            <h4>✅ Structure et contenu :</h4>
            <ul>
                <li>Titre accrocheur et informatif</li>
                <li>Introduction qui captive le lecteur</li>
                <li>Développement structuré avec des sous-titres</li>
                <li>Conclusion qui apporte de la valeur</li>
            </ul>
        </div>
        
        <div class="tips">
            <h4>🔍 Style et qualité :</h4>
            <ul>
                <li>Orthographe et grammaire</li>
                <li>Ton adapté à notre audience</li>
                <li>Sources et références citées</li>
                <li>Images et médias appropriés</li>
            </ul>
        </div>
        
        <div class="tips">
            <h4>🎯 Critères Excellence Afrik :</h4>
            <ul>
                <li>Pertinence pour l'écosystème africain</li>
                <li>Valeur ajoutée pour les lecteurs</li>
                <li>Originalité et perspective unique</li>
                <li>Respect de notre ligne éditoriale</li>
            </ul>
        </div>
        
        <h3>🚀 Prochaines étapes :</h3>
        <ol>
            <li>Accédez à votre tableau de bord</li>
            <li>Apportez les corrections nécessaires</li>
            <li>Soumettez à nouveau votre article</li>
            <li>Notre équipe le révisera rapidement</li>
        </ol>
        
        <p><strong>Nous croyons en votre potentiel !</strong> N'hésitez pas à nous contacter si vous avez des questions.</p>
    </div>
    
    <div class="footer">
        <p><strong>Excellence Afrik</strong> - Plateforme de gestion éditoriale</p>
        <p>Ensemble, créons du contenu d'exception pour l'Afrique !</p>
    </div>
</body>
</html>