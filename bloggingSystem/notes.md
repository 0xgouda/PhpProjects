- $stmt->fetch(PDO::FETCH_ASSOC) is used to read the next
    available row while `PDO::FETCH_ASSOC` specifies that 
    results should be assoc arrays 'column' => 'value'
- $sql = '... :id ...' $stmt = $pdo->prepare($sql); $stmt->execute(['id' => 1])
- when you use php's session_start() php sends the user's browser a cookie containing a random identifier and that identifier corresponds to a file on the server storing variables related to this session
- $success = password_verify($password, $hash) is used to check passwords that were made with password_hash()
- when using session_start() php checks if a session id exists in the user request and if this id has a file and loads this file contents into the $_SESSION super global if no it creates a one

- $params = session_get_cookie_params() // get the parameters that were used to create the session like httponly domain attached, path attached ...etc
    
- set cookie on behalf of the client //  setcookie(session_name() // PHPSESSID, '', time() - 42000,
$params['path'], $params['domain'],
$params['secure'], $params['httponly']);