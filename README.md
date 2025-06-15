# WordPress Gmail SMTP Integration

Plugin WordPress pentru integrare simplă cu Gmail SMTP pentru trimiterea emailurilor din WordPress.

## Descriere

Acest plugin oferă o integrare ușoară cu Gmail SMTP pentru a asigura livrarea corectă a emailurilor din WordPress. Este special conceput pentru a funcționa cu conturile Gmail și include autentificare OAuth2 pentru securitate maximă.

## Caracteristici

- Integrare simplă cu Gmail SMTP
- Autentificare OAuth2 securizată
- Configurare automată pentru WooCommerce
- Test de email direct din panoul de administrare
- Suport pentru DKIM și SPF
- Logging detaliat pentru depanare
- Compatibilitate cu WordPress Multisite

## Cerințe

- WordPress 5.0 sau mai nou
- PHP 7.4 sau mai nou
- Cont Gmail sau Google Workspace
- Credențiale OAuth2 de la Google Cloud Console

## Instalare

1. Descărcați arhiva zip a plugin-ului
2. În panoul de administrare WordPress, mergeți la Plugins > Add New > Upload Plugin
3. Selectați arhiva descărcată și apăsați "Install Now"
4. După instalare, activați plugin-ul
5. Mergeți la Settings > Gmail SMTP pentru configurare

## Configurare

1. Creați un proiect în Google Cloud Console
2. Activați Gmail API pentru proiect
3. Configurați ecranul de consimțământ OAuth
4. Creați credențiale OAuth2 (Client ID și Client Secret)
5. Introduceți credențialele în setările plugin-ului
6. Autorizați aplicația cu contul Gmail dorit
7. Testați trimiterea de email

## Dezvoltare

Acest plugin este dezvoltat și întreținut ca parte a unui sistem mai mare de aprovizionare WSL. Repository-ul principal poate fi găsit [aici](https://github.com/neosilviu/wsl-provision).

### Contribuții

Contribuțiile sunt binevenite! Vă rugăm să:

1. Fork acest repository
2. Creați un branch pentru feature-ul nou (`git checkout -b feature/AmazingFeature`)
3. Commit modificările (`git commit -m 'Add some AmazingFeature'`)
4. Push la branch (`git push origin feature/AmazingFeature`)
5. Deschideți un Pull Request

## Changelog

### 1.0.1 (15 Iunie 2025)
- Adăugat suport pentru logging detaliat
- Îmbunătățit procesul de autentificare OAuth2
- Adăugat suport pentru DKIM
- Optimizări de performanță

### 1.0.0 (15 Iunie 2025)
- Lansare inițială
- Integrare Gmail SMTP
- Suport OAuth2
- Configurare WooCommerce
- Interfață de testare

## Licență

Distribuit sub licența GPLv2 sau mai nouă. Vezi `LICENSE` pentru mai multe informații.

## Contact

Nume Proiect - [@twitter_handle](https://twitter.com/twitter_handle)

Link Proiect: [https://github.com/neosilviu/wordpress-gmail-smtp](https://github.com/neosilviu/wordpress-gmail-smtp)
