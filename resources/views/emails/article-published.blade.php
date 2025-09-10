<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article publié</title>
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
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 15px 0;
            font-weight: 600;
        }
        .btn:hover {
            background-color: #1e7e34;
        }
        .celebration {
            background: linear-gradient(135deg, #978340ff 0%, #fab1a0 100%);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
            font-weight: 600;
            color: #2d3436;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            text-align: center;
        }
        .stat-item {
            padding: 10px;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
        }
        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 Félicitations !</h1>
        <p>Votre article a été publié sur Excellence Afrik</p>
    </div>
    
    <div class="content">
        <div class="celebration">
            ✨ Bravo {{ $author->name }} ! Votre travail est maintenant visible par des milliers de lecteurs ! ✨
        </div>
        
        <h2>Votre article est maintenant en ligne</h2>
        
        <p>Nous avons le plaisir de vous informer que votre article a été approuvé et publié sur Excellence Afrik.</p>
        
        <div class="article-info">
            <h3>📄 Détails de la publication :</h3>
            <p><strong>Titre :</strong> {{ $article->title }}</p>
            <p><strong>Catégorie :</strong> {{ $article->category->name ?? 'Non spécifiée' }}</p>
            <p><strong>Date de publication :</strong> {{ $article->published_at ? $article->published_at->format('d/m/Y à H:i') : now()->format('d/m/Y à H:i') }}</p>
            @if($article->excerpt)
                <p><strong>Extrait :</strong> {{ Str::limit($article->excerpt, 200) }}</p>
            @endif
        </div>
        
        <div style="text-align: center;">
            <a href="{{ $articleUrl }}" class="btn">
                🌐 Voir l'article en ligne
            </a>
        </div>
        
        <h3>🚀 Partagez votre succès</h3>
        <p>N'hésitez pas à partager votre article sur vos réseaux sociaux pour maximiser sa visibilité :</p>
        <ul>
            <li>📱 Partager sur LinkedIn</li>
            <li>🐦 Partager sur Twitter</li>
            <li>📘 Partager sur Facebook</li>
            <li>💼 Inclure dans votre portfolio</li>
        </ul>
        
        <h3>📊 Suivi de performance</h3>
        <p>Vous pouvez suivre les performances de votre article depuis votre tableau de bord :</p>
        <ul>
            <li>📈 Nombre de vues</li>
            <li>👥 Engagement des lecteurs</li>
            <li>💬 Commentaires et réactions</li>
        </ul>
        
        <p><strong>Continuez votre excellent travail !</strong> Nous attendons avec impatience vos prochaines contributions.</p>
    </div>
    
    <div class="footer">
        <p><strong>Excellence Afrik</strong> - Plateforme de gestion éditoriale</p>
        <p>Merci de contribuer à l'excellence du contenu africain !</p>
    </div>
</body>
</html>