<?php

namespace Commission\Providers\ExchangeRates;

use Commission\Providers\ExchangeRates\Exceptions\BadConnectionException;
use Commission\Providers\ExchangeRates\Exceptions\CurrencyRateNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ExchangeRatesProvider implements ExchangeRatesProviderInterface
{
    private const url = 'https://api.exchangeratesapi.io/v1/latest';

    private array $rates = [];

    /**
     * @throws BadConnectionException
     * @throws CurrencyRateNotFoundException
     */
    public function run(string $currency): float
    {
        if (empty($this->rates)) {
            $this->fetchRates();
        }

        if (!isset($this->rates[$currency])) {
            throw new CurrencyRateNotFoundException("Unknown currency '{$currency}'");
        }

        return $this->rates[$currency];
    }

    /**
     * @throws BadConnectionException
     * @throws GuzzleException
     */
    private function fetchRates(): void
    {
        $client = new Client();
        $response = $client->get(self::url . '?access_key=' . $_ENV['EXCHANGE_RATES_API_KEY']);

        if ($response->getStatusCode() !== 200) {
            throw new BadConnectionException("Exchange Rates API Server response code is '{$response->getStatusCode()}'");
        }

        $data = json_decode($response->getBody()->getContents(), true);

        if (!$data['success']) {
            throw new BadConnectionException($data['error']['info']);
        }

        $this->rates = [
            ...$data['rates'],
            'EUR' => 1,
        ];
    }
}

// API response example:
//{"success":true,"timestamp":1737238156,"base":"EUR","date":"2025-01-18","rates":{"AED":3.788787,"AFN":75.670591,"ALL":98.34174,"AMD":413.585822,"ANG":1.858934,"AOA":942.290563,"ARS":1070.844961,"AUD":1.665879,"AWG":1.856722,"AZN":1.757666,"BAM":1.957626,"BBD":2.082643,"BDT":125.326914,"BGN":1.962109,"BHD":0.388763,"BIF":3051.846982,"BMD":1.031512,"BND":1.409615,"BOB":7.127649,"BRL":6.272301,"BSD":1.031462,"BTC":9.839305e-6,"BTN":89.2943,"BWP":14.406439,"BYN":3.375649,"BYR":20217.640464,"BZD":2.071933,"CAD":1.494713,"CDF":2924.337655,"CHF":0.943506,"CLF":0.037718,"CLP":1045.765565,"CNY":7.555869,"CNH":7.573126,"COP":4482.881954,"CRC":517.082371,"CUC":1.031512,"CUP":27.335075,"CVE":110.367959,"CZK":25.365304,"DJF":183.681351,"DKK":7.493528,"DOP":63.178938,"DZD":139.880491,"EGP":51.80733,"ERN":15.472684,"ETB":129.231256,"EUR":1,"FJD":2.404562,"FKP":0.84954,"GBP":0.847534,"GEL":2.929898,"GGP":0.84954,"GHS":15.369338,"GIP":0.84954,"GMD":74.788612,"GNF":8917.318714,"GTQ":7.963429,"GYD":215.801315,"HKD":8.031788,"HNL":26.238477,"HRK":7.612094,"HTG":134.655616,"HUF":414.775035,"IDR":16896.841442,"ILS":3.673236,"IMP":0.84954,"INR":89.304726,"IQD":1351.260553,"IRR":43426.66687,"ISK":146.124426,"JEP":0.84954,"JMD":162.972032,"JOD":0.73145,"JPY":161.232629,"KES":133.574608,"KGS":90.206144,"KHR":4164.885303,"KMF":494.249499,"KPW":928.361156,"KRW":1504.337258,"KWD":0.318294,"KYD":0.859602,"KZT":547.200468,"LAK":22501.99147,"LBP":92368.768206,"LKR":305.76524,"LRD":195.982827,"LSL":19.311515,"LTL":3.045788,"LVL":0.623952,"LYD":5.099757,"MAD":10.362667,"MDL":19.474167,"MGA":4835.510911,"MKD":61.592458,"MMK":3350.311611,"MNT":3505.078799,"MOP":8.272517,"MRU":40.980229,"MUR":48.337055,"MVR":15.890487,"MWK":1788.568505,"MXN":21.436837,"MYR":4.648034,"MZN":65.924338,"NAD":19.311515,"NGN":1602.299971,"NIO":37.955408,"NOK":11.828078,"NPR":142.871281,"NZD":1.848274,"OMR":0.395739,"PAB":1.031462,"PEN":3.876917,"PGK":4.194913,"PHP":60.389925,"PKR":287.461565,"PLN":4.280093,"PYG":8125.580123,"QAR":3.761209,"RON":4.998506,"RSD":117.619257,"RUB":105.36279,"RWF":1436.540108,"SAR":3.870376,"SBD":8.734854,"SCR":15.474436,"SDG":619.939223,"SEK":11.550854,"SGD":1.410803,"SHP":0.84954,"SLE":23.498232,"SLL":21630.296434,"SOS":589.449881,"SRD":36.159702,"STD":21350.221344,"SVC":9.02542,"SYP":13411.722501,"SZL":19.307011,"THB":35.598559,"TJS":11.258603,"TMT":3.620608,"TND":3.318095,"TOP":2.415909,"TRY":36.672582,"TTD":7.003533,"TWD":33.957763,"TZS":2609.634454,"UAH":43.428713,"UGX":3800.545421,"USD":1.031512,"UYU":45.452401,"UZS":13375.477604,"VES":56.78199,"VND":26128.205763,"VUV":122.463208,"WST":2.889087,"XAF":656.569495,"XAG":0.034004,"XAU":0.000382,"XCD":2.787714,"XDR":0.795042,"XOF":656.569495,"XPF":119.331742,"YER":257.104808,"ZAR":19.330112,"ZMK":9284.851931,"ZMW":28.649727,"ZWL":332.14653}}