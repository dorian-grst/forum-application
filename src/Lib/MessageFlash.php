<?php

namespace App\Nig\Lib;

use App\Nig\Model\HTTP\Session;

class MessageFlash
{

    private static string $cleFlash = "_messagesFlash";
    private static $type = ['success', 'danger', 'info', 'warning'];



    public static function ajouter(string $type, string $message): void
    {
        $tab = self::lireTousLesMesssages();
        $tab[$type][] = $message;
        Session::getInstance()->enregistrer(static::$cleFlash, $tab);
    }

    public static function contientMessage(string $type): bool
    {
        if (!Session::getInstance()->contient(static::$cleFlash)) {
            return false;
        } else if (!isset(Session::getInstance()->lire(static::$cleFlash)[$type])) {
            return false;
        } else if (count(Session::getInstance()->lire(static::$cleFlash)[$type]) == 0) {
            return false;
        }
        return true;
    }

    public static function lireTousLesMesssages(): array
    {
        $res = [];
        foreach (static::$type as $k) {
            $res[$k] = self::lireMessages($k);
        }
        return $res;
    }

    public static function lireMessages(string $type): array
    {
        if (self::contientMessage($type)) {
            $tab = Session::getInstance()->lire(static::$cleFlash);
            $res = $tab[$type];
            unset($tab[$type]);
            Session::getInstance()->enregistrer(static::$cleFlash, $tab);
            return $res;
        }
        return [];
    }

    public static function afficher(array $tab) : string {
        if ($tab['type'] == '')
            return '';
        \ob_start();
        ?>
        <div class="alert alert-<?php echo $tab['type']; ?>" role="alert">
            <?php echo $tab['message']; ?>
        </div>
        <?php
        // unset($_SESSION[static::$cleFlash]['type']);
        return \ob_get_clean();
    }
}