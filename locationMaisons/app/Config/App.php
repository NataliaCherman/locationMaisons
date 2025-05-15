<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class App extends BaseConfig
{

// SESSION et COOKIES
public $session = [
    'driver'         => 'CodeIgniter\Session\Handlers\CookieHandler',  // Utiliser les cookies pour gérer la session
    'cookieName'     => 'ci_session',  // Nom du cookie de session
    'expiration'     => 7200,  // Durée de vie de la session en secondes (par exemple, 2 heures)
    'savePath'       => null,  // Le chemin de stockage est nul car on utilise des cookies
    'matchIP'        => false,  // Ne pas forcer la correspondance IP
    'secure'         => false, // Si vous utilisez HTTPS, mettez à true
    'httponly'       => true,  // Empêche l'accès JavaScript aux cookies
    'samesite'       => 'Lax', // Politique SameSite pour les cookies
];

/*
L'extrait de code que tu as partagé configure la gestion de la session dans une application CodeIgniter en utilisant des cookies au lieu de la méthode traditionnelle de gestion de session basée sur des fichiers. Voici une explication de chaque paramètre et ce qu'il implique dans ton application :

Utilisation des cookies pour gérer la session
'driver' => 'CodeIgniter\Session\Handlers\CookieHandler' :

Cela indique que CodeIgniter doit utiliser un gestionnaire de sessions basé sur des cookies plutôt que de stocker les sessions dans des fichiers ou une base de données. L'avantage ici est que les données de session sont stockées côté client dans le cookie plutôt que sur le serveur.

'cookieName' => 'ci_session' :

Il s'agit du nom du cookie qui sera utilisé pour stocker les données de session. Ce nom peut être personnalisé selon tes besoins.

'expiration' => 7200 :

La durée de vie du cookie, en secondes. Ici, c'est défini à 7200 secondes (soit 2 heures). Après cette période, le cookie sera supprimé automatiquement.

'savePath' => null :

Comme les données de session sont stockées dans le cookie (et non sur le serveur), cette option est mise à null pour indiquer qu'il n'y a pas de chemin de stockage spécifique sur le serveur.

'matchIP' => false :

Si cette option est activée (true), elle vérifie que l'adresse IP du client correspond à celle qui a été utilisée lors de la création de la session. L'option est définie sur false, donc la vérification de l'IP est désactivée, ce qui peut rendre la gestion de la session plus flexible, mais légèrement moins sécurisée.

'secure' => false :

Si ton application utilise HTTPS, tu devrais mettre ce paramètre à true pour que les cookies ne soient envoyés que sur des connexions sécurisées. Si ton application fonctionne en HTTP (non sécurisé), laisse-le à false.

'httponly' => true :

Cette option empêche l'accès au cookie via JavaScript, ce qui renforce la sécurité en limitant les risques d'attaques XSS (Cross-Site Scripting).

'samesite' => 'Lax' :

Cette option contrôle la politique SameSite des cookies. 'Lax' signifie que le cookie sera envoyé lors de requêtes de navigation inter-domaines (par exemple, si l'utilisateur clique sur un lien provenant d'un autre domaine), mais pas lors des requêtes POST provenant d'autres sites. Cela peut aider à réduire les risques de CSRF (Cross-Site Request Forgery).

Est-ce vraiment utile dans ton app CodeIgniter ?
Cela dépend de ton besoin. Si tu veux éviter de stocker des données de session sur le serveur et préférer les stocker directement dans le navigateur du client, cette configuration pourrait être utile. Cependant, il y a quelques points à considérer :

Sécurité : Stocker des données sensibles dans des cookies peut être risqué, car les cookies peuvent être facilement interceptés si la connexion n'est pas sécurisée (HTTPS). De plus, même avec des options comme 'httponly' => true et 'secure' => true, certaines informations sensibles devraient probablement être stockées côté serveur pour plus de sécurité.

Taille du cookie : Les cookies ont une taille limitée (généralement autour de 4 Ko), ce qui signifie que tu ne peux pas stocker de grandes quantités de données de session.

Déconnexions automatiques : Comme les cookies ont une expiration définie (7200 secondes ici), l'utilisateur sera automatiquement déconnecté après cette durée, ce qui peut ne pas être souhaité dans certaines applications.

En résumé, cette configuration est utile pour des sessions simples et lorsque la sécurité n'est pas une priorité absolue (ou si elle est renforcée par HTTPS et d'autres mesures de sécurité). Pour des applications nécessitant un niveau de sécurité plus élevé (par exemple, avec des données sensibles), il est souvent préférable de garder les sessions côté serveur.







Vous avez dit :
mais je ne crée par de cookies à côté


ChatGPT a dit :
Tu as raison, dans ton extrait de code, tu n’as pas besoin de créer les cookies toi-même, car CodeIgniter gère automatiquement la création et la gestion des cookies de session lorsque tu utilises le gestionnaire de sessions basé sur des cookies (CookieHandler).

Comment ça fonctionne :
CodeIgniter gère la session à travers des cookies automatiquement. Lorsqu'un utilisateur visite ton site, CodeIgniter crée un cookie appelé ci_session (ou le nom que tu as défini) pour stocker les informations de session.

Aucune gestion manuelle des cookies n'est nécessaire de ta part, tu définis simplement la configuration comme tu l'as fait, et CodeIgniter s'occupe de l'enregistrement et de la récupération des données de session dans ce cookie.

Quelques points à garder à l'esprit :
Durée de vie du cookie : Le cookie sera automatiquement défini avec une expiration de 2 heures (7200 secondes) comme tu l'as configuré. Après cette période, il expirera et l'utilisateur devra se reconnecter (si nécessaire).

Pas de stockage côté serveur : Contrairement à la méthode traditionnelle de gestion des sessions (stockées côté serveur dans des fichiers ou une base de données), ici, toutes les informations de session sont stockées directement dans le cookie sur le navigateur du client. C'est pour cela que tu n'as pas besoin de créer ou de gérer manuellement ces cookies.

Sécurisation du cookie : Même si tu n’as pas besoin de créer manuellement les cookies, il est toujours important de définir des options de sécurité comme 'secure' => true (si tu utilises HTTPS), 'httponly' => true et 'samesite' => 'Lax' pour protéger les cookies contre les attaques potentielles comme XSS et CSRF.

Résumé :
Pas besoin de créer des cookies à côté : CodeIgniter s’en charge automatiquement.

Le cookie ci_session est géré par CodeIgniter : Il contient les données de session (par exemple, l’ID de session) et il est automatiquement envoyé et récupéré par le navigateur à chaque requête.

Gestion simplifiée : Tu définis simplement les paramètres de configuration dans app/config/App.php ou app/config/Session.php, et CodeIgniter se charge de tout le reste.

Donc, pour résumer, si tu utilises ce gestionnaire de sessions basé sur des cookies, tu n’as pas à te soucier de la création ou gestion manuelle des cookies. CodeIgniter le fait pour toi.
*/


    /**
     * --------------------------------------------------------------------------
     * Base Site URL
     * --------------------------------------------------------------------------
     *
     * URL to your CodeIgniter root. Typically, this will be your base URL,
     * WITH a trailing slash:
     *
     *    http://example.com/
     */
    public string $baseURL = 'http://localhost/locationMaisons/';

    /**
     * Allowed Hostnames in the Site URL other than the hostname in the baseURL.
     * If you want to accept multiple Hostnames, set this.
     *
     * E.g. When your site URL ($baseURL) is 'http://example.com/', and your site
     *      also accepts 'http://media.example.com/' and
     *      'http://accounts.example.com/':
     *          ['media.example.com', 'accounts.example.com']
     *
     * @var list<string>
     */
    public array $allowedHostnames = [];

    /**
     * --------------------------------------------------------------------------
     * Index File
     * --------------------------------------------------------------------------
     *
     * Typically this will be your index.php file, unless you've renamed it to
     * something else. If you are using mod_rewrite to remove the page set this
     * variable so that it is blank.
     */
    public string $indexPage = 'index.php';

    /**
     * --------------------------------------------------------------------------
     * URI PROTOCOL
     * --------------------------------------------------------------------------
     *
     * This item determines which server global should be used to retrieve the
     * URI string.  The default setting of 'REQUEST_URI' works for most servers.
     * If your links do not seem to work, try one of the other delicious flavors:
     *
     * 'REQUEST_URI'    Uses $_SERVER['REQUEST_URI']
     * 'QUERY_STRING'   Uses $_SERVER['QUERY_STRING']
     * 'PATH_INFO'      Uses $_SERVER['PATH_INFO']
     *
     * WARNING: If you set this to 'PATH_INFO', URIs will always be URL-decoded!
     */
    public string $uriProtocol = 'REQUEST_URI';

    /**
     * --------------------------------------------------------------------------
     * Default Locale
     * --------------------------------------------------------------------------
     *
     * The Locale roughly represents the language and location that your visitor
     * is viewing the site from. It affects the language strings and other
     * strings (like currency markers, numbers, etc), that your program
     * should run under for this request.
     */
    public string $defaultLocale = 'en';

    /**
     * --------------------------------------------------------------------------
     * Negotiate Locale
     * --------------------------------------------------------------------------
     *
     * If true, the current Request object will automatically determine the
     * language to use based on the value of the Accept-Language header.
     *
     * If false, no automatic detection will be performed.
     */
    public bool $negotiateLocale = false;

    /**
     * --------------------------------------------------------------------------
     * Supported Locales
     * --------------------------------------------------------------------------
     *
     * If $negotiateLocale is true, this array lists the locales supported
     * by the application in descending order of priority. If no match is
     * found, the first locale will be used.
     *
     * IncomingRequest::setLocale() also uses this list.
     *
     * @var string[]
     */
    public array $supportedLocales = ['en'];

    /**
     * --------------------------------------------------------------------------
     * Application Timezone
     * --------------------------------------------------------------------------
     *
     * The default timezone that will be used in your application to display
     * dates with the date helper, and can be retrieved through app_timezone()
     *
     * @see https://www.php.net/manual/en/timezones.php for list of timezones supported by PHP.
     */
    public string $appTimezone = 'UTC';

    /**
     * --------------------------------------------------------------------------
     * Default Character Set
     * --------------------------------------------------------------------------
     *
     * This determines which character set is used by default in various methods
     * that require a character set to be provided.
     *
     * @see http://php.net/htmlspecialchars for a list of supported charsets.
     */
    public string $charset = 'UTF-8';

    /**
     * --------------------------------------------------------------------------
     * Force Global Secure Requests
     * --------------------------------------------------------------------------
     *
     * If true, this will force every request made to this application to be
     * made via a secure connection (HTTPS). If the incoming request is not
     * secure, the user will be redirected to a secure version of the page
     * and the HTTP Strict Transport Security header will be set.
     */
    public bool $forceGlobalSecureRequests = false;

    /**
     * --------------------------------------------------------------------------
     * Reverse Proxy IPs
     * --------------------------------------------------------------------------
     *
     * If your server is behind a reverse proxy, you must whitelist the proxy
     * IP addresses from which CodeIgniter should trust headers such as
     * X-Forwarded-For or Client-IP in order to properly identify
     * the visitor's IP address.
     *
     * You need to set a proxy IP address or IP address with subnets and
     * the HTTP header for the client IP address.
     *
     * Here are some examples:
     *     [
     *         '10.0.1.200'     => 'X-Forwarded-For',
     *         '192.168.5.0/24' => 'X-Real-IP',
     *     ]
     *
     * @var array<string, string>
     */
    public array $proxyIPs = [];

    /**
     * --------------------------------------------------------------------------
     * Content Security Policy
     * --------------------------------------------------------------------------
     *
     * Enables the Response's Content Secure Policy to restrict the sources that
     * can be used for images, scripts, CSS files, audio, video, etc. If enabled,
     * the Response object will populate default values for the policy from the
     * `ContentSecurityPolicy.php` file. Controllers can always add to those
     * restrictions at run time.
     *
     * For a better understanding of CSP, see these documents:
     *
     * @see http://www.html5rocks.com/en/tutorials/security/content-security-policy/
     * @see http://www.w3.org/TR/CSP/
     */
    public bool $CSPEnabled = false;
}
