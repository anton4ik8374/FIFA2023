<?php
namespace App\Helpers;
final class CountTokens
{
    public static function count(string $text) : int
    {
        $text = str_replace('"', '\"', $text); // Escape double quotes
        $command = "python3 -m tiktoken -t \"$text\"";
        $output = shell_exec($command);
        $json_output = json_decode($output, true);

        if ($json_output === null) {
            // There was an error with the JSON data, handle accordingly
            return -1;
        }

        // Return the token count
        return $json_output['n_tokens'];
    }
}
