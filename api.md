# APIs Externes - Excellence Afrik

Ce document résume les différentes APIs externes utilisées sur le site Excellence Afrik pour afficher les données en temps réel dans le header.

## 🌍 API Météo - OpenWeatherMap

### **Description**
Affichage de la météo en temps réel pour Abidjan, Côte d'Ivoire.

### **Configuration**
- **Service** : OpenWeatherMap API
- **Clé API** : `f66a0e148241fe356827681a7ea53ad3`
- **URL** : `https://api.openweathermap.org/data/2.5/weather`
- **Ville** : Abidjan, CI
- **Langue** : Français (`lang=fr`)
- **Unités** : Métriques (`units=metric`)

### **Route Laravel**
```php
Route::get('/api/weather', function () {
    $apiKey = 'f66a0e148241fe356827681a7ea53ad3';
    $city = 'Abidjan';
    $countryCode = 'CI';
    
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city},{$countryCode}&units=metric&lang=fr&appid={$apiKey}";
    // ...
})->name('api.weather');
```

### **Données Retournées**
```json
{
    "success": true,
    "data": {
        "temp": 29,
        "description": "ciel dégagé",
        "city": "Abidjan"
    }
}
```

### **Gestion d'Erreurs**
- **Fallback** : Température 29°C avec message "API temporairement indisponible"
- **Timeout** : Gestion automatique des erreurs de connexion

---

## 💱 API Conversion Monétaire - ExchangeRate-API

### **Description**
Affichage des taux de change EUR/CFA et USD/CFA en temps réel.

### **Configuration**
- **Service** : ExchangeRate-API
- **URL Base** : `https://api.exchangerate-api.com/v4/latest/`
- **Devises** : EUR → XOF, USD → XOF
- **Actualisation** : Automatique toutes les heures

### **Implémentation JavaScript**
```javascript
class CurrencyExchange {
    async fetchExchangeRates() {
        // EUR vers CFA
        const eurResponse = await fetch('https://api.exchangerate-api.com/v4/latest/EUR');
        const eurData = await eurResponse.json();
        const eurToCfa = eurData.rates.XOF;
        
        // USD vers CFA  
        const usdResponse = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
        const usdData = await usdResponse.json();
        const usdToCfa = usdData.rates.XOF;
    }
}
```

### **Affichage**
- **EUR/CFA** : 1 EUR = XXX CFA
- **USD/CFA** : 1 USD = XXX CFA
- **Format** : Arrondi à 2 décimales
- **Actualisation** : Toutes les heures

### **Gestion d'Erreurs**
- **CORS** : Résolu par utilisation côté serveur Laravel
- **Fallback** : Valeurs par défaut si API indisponible

---

## 📈 API Bourse - BRVM (Simulé)

### **Description**
Affichage des données de la Bourse Régionale des Valeurs Mobilières (BRVM) avec simulation temps réel.

### **Configuration**
- **Indice Principal** : BRVM10
- **Valeur de Base** : 161.50
- **Variation** : ±2% aléatoire
- **Horaires** : 9h-15h UTC (heures de bourse)

### **Route Laravel**
```php
Route::get('/api/brvm', function () {
    $baseValue = 161.50;
    $variation = (rand(-200, 200) / 100); // -2% à +2%
    $currentValue = round($baseValue + $variation, 2);
    
    $changePercent = round(($variation / $baseValue) * 100, 2);
    $changeClass = $changePercent >= 0 ? 'positive' : 'negative';
    
    // Simulation horaire de la bourse
    $currentHour = (int)date('H');
    $isMarketOpen = $currentHour >= 9 && $currentHour < 15;
    
    return response()->json([
        'success' => true,
        'data' => [
            'index_name' => 'BRVM10',
            'value' => $currentValue,
            'change_percent' => $changePercent,
            'change_display' => ($changePercent >= 0 ? '+' : '') . $changePercent . '%',
            'change_class' => $changeClass,
            'market_open' => $isMarketOpen,
            'last_update' => now()->format('H:i')
        ]
    ]);
})->name('api.brvm');
```

### **Données Retournées**
```json
{
    "success": true,
    "data": {
        "index_name": "BRVM10",
        "value": 163.25,
        "change_percent": 1.08,
        "change_display": "+1.08%",
        "change_class": "positive",
        "market_open": true,
        "last_update": "14:30"
    }
}
```

### **Caractéristiques**
- **Simulation Réaliste** : Variations typiques d'un indice boursier
- **Horaires de Marché** : Indicateur d'ouverture/fermeture
- **Mise à Jour** : Temps réel avec timestamp
- **Couleurs** : Vert (positif), Rouge (négatif)

---

## 🔧 Intégration Frontend

### **Chargement Automatique**
```javascript
// Dans layouts/app.blade.php
document.addEventListener('DOMContentLoaded', function() {
    const weatherWidget = new WeatherWidget();
    const currencyWidget = new CurrencyExchange();
    const brvmWidget = new BRVMWidget();
    
    // Chargement initial
    weatherWidget.loadWeather();
    currencyWidget.loadRates();
    brvmWidget.loadData();
    
    // Actualisation périodique
    setInterval(() => currencyWidget.loadRates(), 3600000); // 1 heure
    setInterval(() => brvmWidget.loadData(), 300000); // 5 minutes
});
```

### **Gestion d'Erreurs Globale**
- **Fallback** : Valeurs par défaut pour chaque API
- **Retry** : Nouvelle tentative en cas d'échec
- **Timeout** : Limite de temps pour éviter les blocages
- **UX** : Indicateurs visuels d'état (chargement, erreur, succès)

---

## 📊 Monitoring & Performance

### **Recommandations**
1. **Cache** : Mise en cache des réponses API (Redis/Memcached)
2. **Rate Limiting** : Limitation des appels pour éviter les quotas
3. **Monitoring** : Surveillance de la disponibilité des APIs
4. **Logs** : Enregistrement des erreurs et performances
5. **CDN** : Utilisation d'un CDN pour réduire la latence

### **Améliorations Futures**
- **WebSocket** : Données temps réel sans polling
- **API BRVM Réelle** : Intégration avec les vraies données BRVM
- **Plus de Devises** : Ajout d'autres paires de change
- **Graphiques** : Historique des cours et tendances