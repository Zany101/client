<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;

use App\Entity\Service;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction("date", [$this, "formatDate"]),
            new TwigFunction("size", [$this, "formatBytes"]),
            new TwigFunction("breadcrumbs", [$this, "breadcrumbs"]),
            new TwigFunction("str_replace", [$this, "remove_name_space"]),
            new TwigFunction("print_r", [$this, "print_r"]),
            new TwigFunction("command_parse", [$this, "command_parse"]),
            new TwigFunction("template", [$this, "template"]),
            new TwigFunction("moneyFormatter", [$this, "money_formater"]),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter("cast_to_array", [$this, "objectFilter"]),
            new TwigFilter("time", [$this, "time"]),
            new TwigFilter("operating_system", [$this, "operating_system"]),
            new TwigFilter("boolean", [$this, "boolean"]),
            new TwigFilter("proccess", [$this, "proccess"]),
            new TwigFilter("game_type", [$this, "game_type"]),
            new TwigFilter("string_to_symbols", [$this, "string_to_symbols"]),
        ];
    }

    public function get_object($object) {
      // {% if item.object == null %}
      //   {% set object = rows %}
      // {% else %}
      //   {% set object =  attribute(rows, item.object) %}
      // {% endif %}

      if ($object == null) {

        return;
      }

      return;
    }

    public function string_to_symbols($string, $symbol = "*")
    {
        return str_repeat ($symbol, strlen ($string));
    }

    public function print_r($object)
    {
        return print_r($object);
    }

    public function game_type($object)
    {
        if ($object) {
          return "Game Server";
        }

        return "Voice Server";
    }

    public function proccess($pid) {

        if ($pid != null) {
            return "Online (PID $pid)";
        }

        return "Ofline";
    }

    public function operating_system(int $int)
    {
        $os = [
            0 => "Unknown",
            1 => "windows",
            2 => "linux",
            3 => "mac",
            4 => "Unknown2",
        ];
        return $os[$int];
    }

    public function boolean($int)
    {
        $bool = ["false", "true"];
        return $bool[$int];
    }

    public function remove_name_space($search, $subject)
    {
        $trimmed = str_replace($search, "", $subject);
        return $trimmed;
    }

    public function objectFilter($stdClassObject)
    {
        $response = (array) $stdClassObject;

        return $response;
    }

    public function time($time)
    {
        if ($time != null) {
            $time = date("G\h\ i\m\ s\s\\", $time);
        } else {
            $time = "";
        }
        return $time;
    }

    public function formatDate($date)
    {
        if ($date != null) {
            $date = date("F j, Y", $date);
        } else {
            $date = "";
        }
        return $date;
    }

    public function template($data)
    {
        /* Use tab and newline as tokenizing characters as well  */
        $tok = strtok($data, "/");

        while ($tok !== false) {
            $parts[] = $tok;
            $tok = strtok("/");
        }
        $filename = explode(".", end($parts));

        return $filename[0];
    }

    function formatBytes($bytes, $precision = 2)
    {
        $units = ["B", "KB", "MB", "GB", "TB"];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        if ($bytes > 0) {
            return round($bytes, $precision) . " " . $units[$pow];
        } else {
            return;
        }
    }

    function command_parse($command, ?Service $service)
    {
        $data = [
            "ip_address" => $service->getGameServices()->getIpAddress(),
            "game_port" => $service->getGameServices()->getGamePort(),
            "query_port" => $service->getGameServices()->getQueryPort(),
            "custom_port1" => $service->getGameServices()->getCustomPort1(),
            "slots" => $service->getGameServices()->getSlots(),
            "server_cfg" => $service
                ->getGameServices()
                ->getGame()
                ->getGameConfigFiles()[0]
                ->getRelativePath(),
        ];

        $options = [
            '$[Service.IpAddress]' => $data["ip_address"],
            '$[Service.GamePort]' => $data["game_port"],
            '$[Service.QueryPort]' => $data["query_port"],
            '$[Service.CustomPort1]' => $data["custom_port1"],
            '$[Service.Slots]' => $data["slots"],
            "[StartupMap]" => "de_dust2",
            "[ConfigFile]" => $data["server_cfg"],
            "\"server.cfg\"" => $data["server_cfg"],
        ];

        foreach ($options as $key => $option) {
            $command = str_replace($key, $option, $command);
        }
        return $command;
    }

    function money_formater($currency, $amount, $slots=1, $discount=null) {
      $cur = [
        'eur' => [
          'iso' => 'EUR',
          'symbol' => "€",
          'rate' => 1,
        ],
        'usd' => [
          'iso' => 'USD',
          'symbol' => "$",
          'rate' => 1.1,
        ],
        'gbp' => [
          'iso' => 'GBP',
          'symbol' => "£",
          'rate' =>  0.9,
        ],
      ];
      $amount = $discount != null ? $amount / 100 * $discount : $amount;
      $convert = number_format(sprintf('%.2f', $amount / 100 * $slots) * $cur[$currency]['rate'],  2, '.', '' );

      $result = $cur[$currency]['symbol']." ".$convert." ".$cur[$currency]['iso'];


      return $result;
    }

    function breadcrumbs($separator = " &raquo; ", $home = "Home", $start=null, $end=null)
    {
        // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
        $path = array_filter(
            explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))
        );

        // This will build our "base URL" ... Also accounts for HTTPS :)
        $base =
            (@$_SERVER["HTTPS"] ? "https" : "http") .
            "://" .
            $_SERVER["HTTP_HOST"] .
            "/";

        // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
        $breadcrumbs = ["<a href=\"$base\">$home</a>"];

        // Find out the index for the last value in our path array
        $last = @end(array_keys($path));

        $prev = null;

        if ($start != null)
          $key = array_search($start, $path); // $key = 2;

        // Build the rest of the breadcrumbs
        foreach ($path as $x => $crumb) {
          if($x < @$key+1) continue;

            // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
            $title = ucwords(str_replace([".php", "_"], ["", " "], $crumb));

            // If we are not on the last index, then display an <a> tag
            if ($x != $last) {
                $breadcrumbs[] = "<a href=\"$base$prev$crumb\">$title</a>";
            }
            // Otherwise, just display the title (minus)
            else {
                $breadcrumbs[] = $title;
            }

            $prev .= $crumb . "/";

            if($crumb == $end) break;

        }

        // Build our temporary array (pieces of bread) into one big string :)
        echo implode($separator, $breadcrumbs);
    }
}
