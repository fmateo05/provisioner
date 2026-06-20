class KazooCrossbarClient {
    private $apiUrl;
    private $apiKey;
    private $authToken = null;

    public function __construct($apiUrl, $apiKey) {
        // Ejemplo de URL: https://api.2600hz.com:8443
        $this->apiUrl = rtrim($apiUrl, '/');
        $this->apiKey = $apiKey;
    }

    /**
     * Autentica con el clúster de Kazoo usando la API Key para obtener el X-Auth-Token
     */
    private function authenticate() {
        if ($this->authToken !== null) return $this->authToken;

        $url = $this->apiUrl . '/v2/api_auth';
//        $url = $this->apiUrl . '/v2/user_auth';
        $payload = json_encode([
            'data' => [
                'api_key' => $this->apiKey
            ]
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 201) {
            $data = json_decode($response, true);
            $this->authToken = $data['auth_token'];
            return $this->authToken;
        }

        throw new Exception("Error de autenticación en Crossbar. Código HTTP: " . $httpCode);
    }

    /**
     * Reemplaza la consulta de CouchDB para obtener los datos crudos de un dispositivo
     */
    public function getDeviceDetails($accountId, $deviceId) {
        $token = $this->authenticate();
        $url = $this->apiUrl . "/v2/accounts/{$accountId}/devices/{$deviceId}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Auth-Token: ' . $token
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $json = json_decode($response, true);
            // Retorna exactamente el nodo 'data', que contiene los campos del teléfono (MAC, SIP username, etc.)
            return $json['data'];
        }

        return null;
    }
    public function getAccountDetails($accountId) {
        $token = $this->authenticate();
        $url = $this->apiUrl . "/v2/accounts/{$accountId}";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Auth-Token: ' . $token
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $json = json_decode($response, true);
            // Retorna exactamente el nodo 'data', que contiene los campos del teléfono (MAC, SIP username, etc.)
            return $json['data'];
        }

        return null;
    }
}
