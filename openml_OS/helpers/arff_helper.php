<?php
// This function extracts a valid ARFF string (or token) from the given line,
// starting at the given position. It returns the position of the next
// delimiter or the length of the line if none of the delimiters is found.
// In case of success the function fills in $token and returns the position
// after the string, in case of failure it returns an error message string.
function ARFFparseString($line, $pos, &$token, $delimiters)
{
	$len = strlen($line);
	while ($pos < $len and $line[$pos] == ' ') $pos++;
	$end = $pos;
	if ($end == $len) return "unexpected end of line";
	if ($line[$pos] == "\"" or $line[$pos] == "'")
	{
		$quote = $line[$pos];
		$pos++;
		$end = strpos($line, $quote, $pos);
		if ($end === FALSE) return "missing trailing quote in string";
		$token = substr($line, $pos, $end - $pos);
		$end++;
		if ($end == $len) return $end;
		if (strpos($delimiters, $line[$end]) === FALSE)
		{
			while ($end < $len and $line[$end] == ' ') $end++;
			if ($end == $len) return $end;
			if (strpos($delimiters, $line[$end]) === FALSE) return "missing delimiter";
		}
	}
	else
	{
		$del = strlen($delimiters);
		$end = FALSE;
		for ($i=0; $i<$del; $i++)
		{
			$p = strpos($line, $delimiters[$i], $pos);
			if ($p === FALSE) continue;
			if ($end === FALSE or $p < $end) $end = $p;
		}
		if ($end === FALSE) $end = $len;
		$token = trim(substr($line, $pos, $end - $pos));
		if ($end == $len) return $end;
	}
	while ($end < $len and $line[$end] == ' ') $end++;
	return $end;
}
// This function checks whether the content from $filepath appears to be a 
// valid ARFF file. It checks the header section and up to $numLines data lines,
// in dense or sparse format. In case of an ARFF format violation it returns an
// error message string, otherwise it returns TRUE.
function ARFFcheck($filepath, $numLines = 100)
{
	// read header section
	$featureType = [];
	$numberOfNonNumericFeatures = 0;
	$filehandle = fopen($filepath, "r");
	$line = '';
	$lineNumber = -1;
	while (($line = fgets($filehandle)) !== false)
	{
		$line = trim($line);
		$lineNumber += 1;
		if ($line == "") { }
		else if ($line[0] == '%') { }
		else if ($line[0] == '@')
		{
			$pos = strpos($line, " ");
			if ($pos === FALSE) $pos = strlen($line);
			$type = strtolower(substr($line, 0, $pos));
			if ($type == "@data")
			{
				if ($pos != strlen($line)) {
					fclose($filehandle);
					return "trailing content in @data line (l.".$lineNumber.")";
				}
				break;
			}
			else if ($type == "@relation")
			{
				$pos = ARFFparseString($line, $pos, $s, " ");
				if (is_string($pos)) {
					fclose($filehandle);
					return $pos . " (l.".$lineNumber.")";
				}
				if ($pos != strlen($line)) {
					fclose($filehandle);
					return "trailing content in @relation line (l.".$lineNumber.")";
				}
			}
			else if ($type == "@attribute")
			{
				$pos = ARFFparseString($line, $pos, $s, " ");
				if (is_string($pos)) {
					fclose($filehandle);
					return $pos . " (l.".$lineNumber.")";
				}
				
				if ($line[$pos] == '{')
				{
					$pos++;
					$values = [];
					while (TRUE)
					{
						$pos = ARFFparseString($line, $pos, $s, ",}");
						if (is_string($pos)) {
							fclose($filehandle);
							return $pos . " (l.".$lineNumber.")";
						}
						array_push($values, $s);
						if ($line[$pos] == ',') $pos++;
						else if ($line[$pos] == '}') { $pos++; break; }
						else {
							fclose($filehandle);
							return "format error in nominal attribute declaration" . " (l.".$lineNumber.")";
						}
					}
					array_push($featureType, $values);
					$numberOfNonNumericFeatures++;
				}
				else
				{
					$pos = ARFFparseString($line, $pos, $s, "");
					if (is_string($pos)) {
						fclose($filehandle);
						return $pos . " (l.".$lineNumber.")";
					}
					$s = strtolower($s);
					if ($s == "binary" or $s == "integer" or $s == "real") $s = "numeric";   // map nonofficial types to official numeric type
					if ($s != "numeric" and $s != "string" and $s != "date")
					{ 
						fclose($filehandle);
						return "unsupported attribute type: " . $s . " (l.".$lineNumber.")";
					}
					array_push($featureType, $s);
				}
			} else {
				fclose($filehandle);
				return "unsupported header field: " . $type . " (l.".$lineNumber.")";
			}
		}	else {
			fclose($filehandle);
			return "invalid line in ARFF header: " . $line . " (l.".$lineNumber.")";
		}
		$line = strtok("\n");
	}
	$p = count($featureType);   // number of features
	// read up to $numLines lines of data
	$counter = 0;
	$line = strtok("\n");
	while ($line !== FALSE)
	{
		$line = trim($line);
		if ($line == "") { }
		else if ($line[0] == '%') { }
		else
		{
			$len = strlen($line);
			$s = "";
			if ($line[0] == '{')
			{
				// sparse data
				// 1. check that all specified features have valid values
				// 2. check that all nominal features are specified explicitly
				$nonnum = 0;
				$pos = 1;
				while ($pos < $len and $line[$pos] == ' ') $pos++;
				if ($pos < $len and $line[$pos] == '}')
				{
					// empty feature set is syntactically correct
					// as long as all features are numeric
				}
				else
				{
					while (TRUE)
					{
						$pos = ARFFparseString($line, $pos, $s, " ");
						if (is_string($pos)) {
							fclose($filehandle);
							return $pos . " (l.".$lineNumber.")";
						}
						$i = intval($s);
						if ($i < 0 or $i >= $p)
						{
							fclose($filehandle);
							return "invalid feature index: " . $i . " (l.".$lineNumber.")";
						}
						$pos = ARFFparseString($line, $pos, $s, ",}");
						if (is_string($pos)) {
							fclose($filehandle);
							return $pos . " (l.".$lineNumber.")";
						}
						$n = $featureType[$i];
						if ($n == "numeric")
						{
							if ($s != '?' and ! is_numeric($s))
							{
								fclose($filehandle);
								return "invalid value for numeric attribute: " . $s . " (l.".$lineNumber.")";
							}
						}
						else if ($n == "string")
						{
							// everything is allowed here
							$nonnum++;
						}
						else if ($n == "date")
						{
							// date strings are non-trivial to validate, ignore
							$nonnum++;
						}
						else
						{
							// check nominal attribute
							assert(is_array($n));
							if ($s != '?' and array_search($s, $n) === FALSE)
							{
								fclose($filehandle);
								return "invalid value for nominal attribute: " . $s . " (l.".$lineNumber.")";
							}
							$nonnum++;
						}

						if ($pos == $len)
						{
							fclose($filehandle);
							return "closing brace missing in sparse data line" . " (l.".$lineNumber.")";
						}
						if ($line[$pos] == '}') break;
						$pos++;
					}
				}
				if ($nonnum != $numberOfNonNumericFeatures)
				{
					fclose($filehandle);
					return "at least one string, date, or nominal feature value is missing; this is disallowed also in sparse data format";
				}
			}
			else
			{
				// dense data
				$pos = 0;
				for ($i=0; $i<$p; $i++)
				{
					$pos = ARFFparseString($line, $pos, $s, ",");
					if (is_string($pos))
					{
						fclose($filehandle);
						return $pos . " (l.".$lineNumber.")";
					}
					$n = $featureType[$i];
					if ($s != '?' and count($n) != 0)
					{
						// check nominal attribute
						if (array_search($s, $n) === FALSE)
						{
							fclose($filehandle);
							return "invalid nominal attribute value: " . $s . " (l.".$lineNumber.")";
						}
					}
					if ($line[$pos] == ',') $pos++;
				}
				if ($pos < $len)
				{
					fclose($filehandle);
					return "trailing characters on dense data line" . " (l.".$lineNumber.")";
				}
			}
		}
		$line = strtok("\n");
		$count++;
		if ($count == $numLines) break;   // for performance reasons we stop after a fixed number of data lines
	}
	// judged as valid
	return TRUE;
}
?>
