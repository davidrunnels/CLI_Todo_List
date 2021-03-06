<?php

// Create array to hold list of todo items
$items = array();
$azsort = $items;
$orig_items = $items;

// unset($items[0]);

// List array items formatted for CLI
function list_items($list) 
{
    $x = '';
    foreach($list as $key => $item) {
        $key++;
        $x .= "[{$key}] {$item}\n";
    }
    return $x;
     // Return string of list items separated by newlines.
     // Should be listed [KEY] Value like this:
     // [1] TODO item 1
     // [2] TODO item 2 - blah
     // DO NOT USE ECHO, USE RETURN
}

 // Get STDIN, strip whitespace and newlines,
 // and convert to uppercase if $upper is true
 function getInput($upper = false) 
 {
     // Return filtered STDIN input
    if ($upper) {
        return strtoupper(trim(fgets(STDIN)));
    } else {
        return (trim(fgets(STDIN)));

    }
 }

function sortArray($array, $orig_items){
    $input = getInput(true);

    if ($input == 'A') {
        asort($array);
    } elseif ($input == 'Z') {
        arsort($array);
    } elseif ($input == 'O') {
        return $orig_items;
    } elseif ($input == 'R') {
        $array = $orig_items;
        krsort($array);
    }   
    return $array;
}

function readList($list) {
    $items = [];
    if (filesize($list) == 0) {
        echo "File is empty.";
    } else {
        $handle = fopen($list, 'r');
        $contents = fread($handle, filesize($list));
        $items = explode("\n", $contents);
        fclose($handle);
    }
        return $items;
        echo "Save a
        of {$items} was successful.";
}

function writeList($file_name, $contents_array) {
    if (file_exists($file_name)) {
            echo "The file $file_name already exists." . PHP_EOL;
            echo "Do you want to overwrite {$file_name}?" . PHP_EOL;
            $overwrite = getInput(true);
            if ($overwrite == 'N') {
                echo "Overwrite of {$file_name} canceled." . PHP_EOL;
                return;
            }
    }

    $handle = fopen($file_name, 'w');
    foreach ($contents_array as $key) {
        fwrite($handle, $key);

    }   
    fclose($handle);
    return "Save  of file {$file_name} was successful." . PHP_EOL;

}

// function fileCheck($file_name, $contents_array) {
//     if (file_exists($file_name)) {
//         echo "The file $file_name exists";
//         echo "Do you want to overwrite? (Y)es or (N)o: ";
//         $overwrite = getInput();
//             if ($overwrite == 'Y') {
//                 writeList($file_name, $contents_array);

//             }
// } else {
//     echo "The file $filename does not exist";
// }


// }

// The loop!
do {
    echo list_items($items);
//     // Iterate through list items
//     foreach ($items as $key => $item) {
//         // begining index at [1]
//         $key++;
//         // Display each item and a newline
//         echo "[{$key}] {$item}\n";
//     }

    // Show the menu options
    echo '(N)ew item, (R)emove item, (O)pen list, (S)ort list, s(A)ve list, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = trim(fgets(STDIN));
    // force all upper case
    $input = strtoupper($input);

    // Check for actionable input
if ($input == 'N') {
                echo 'Enter item: ';
                // Add entry to list array
                $new_item = trim(fgets(STDIN));
                $orig_items = $items;
        echo 'Add it to the (B)egining or (E)nd of the list: ';     
        $begin_item = getInput(true);
            if ($begin_item == 'B') {
            $item = array_unshift($items, $new_item);
        } else {
            $item = array_push($items, $new_item);
        }

    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = trim(fgets(STDIN));
        // adjust index back to [0]
        $key--;
        // Remove from array
        unset($items[$key]);
        // reindex numerical array
        $items = array_values($items);
    } elseif ($input == 'S') {
        // Sort options
        echo '(A)-Z, (Z)-A, (O)rder entered, (R)everse order entered: ';
        // Get array key
        $items = sortArray($items, $orig_items); 
    } elseif ($input == 'R') {
        $items = array_values($items);
    } elseif ($input == 'F') {
        $item = array_shift($items);
    } elseif ($input == 'L') {
        $item = array_pop($items);
    } elseif ($input == 'O') {
        echo "Enter file path and name.  Example: data/list.txt\n";
        $list = getInput();
        $new_items = readList($list);
        $items = array_merge($items, $new_items);
        // $handle = fopen($list, 'r');
        // $contents = fread($handle, filesize($list));
        // $items = explode("\n", $contents);
        // fclose($handle);
    } elseif ($input == 'A') {
        echo "Enter path and name to save the file.  Example: data/new_list.txt\n";
        $file_name = getInput();
        $contents_array = [];
        $new_items = writeList($file_name, $contents_array);
        // $items = array_merge($items, $new_items);
        echo $new_items;
    }


// Exit when input is (Q)uit
} while ($input != 'Q');


// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);