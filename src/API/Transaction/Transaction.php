<?php

namespace SkyCoin\API\Transaction;


use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\HttpClient;
use SkyCoin\Transaction as trans;

class Transaction
{
    private HttpClient $client;

    /**
     * Generic constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function pendingTxs(string $params=''){
        return $this->client->sendRequest("/v1/pendingTxs?".$params, [], [], "GET");
    }

    /**
     * @param array $hours_selection
     * @param array $addresses
     * @param string $change_address
     * @param array $to
     * @return trans
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function createTransaction(array $hours_selection, array $addresses,string $change_address,array $to) :trans
    {
        $params = array(
            "hours_selection"=> $hours_selection,
            "addresses"=> $addresses,
            "change_address"=> $change_address,
            "to"=>$to
        );
        $result =  $this->client->sendRequest("/v2/transaction", $params, []);
        $transaction = new trans();
        $transaction->id = $result['transaction']['txid'];
        $transaction->fee = $result['transaction']['fee'];
        $transaction->block = $result['transaction']['inputs'][0]['block'];
        $transaction->inputs = $result['transaction']['inputs'];
        $transaction->outputs = $result['transaction']['outputs'];

        return $transaction;
    }

    /**
     * @param string $params
     * @param int|null $confirmed
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function getTransactions(string $params,int $confirmed = null){
        return $this->client->sendRequest("/v1/transactions?addrs=".$params."&confirmed=".$confirmed, [], [], "GET");
    }

    /**
     * @param string $params
     * @param int $param2
     * @return trans
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function getTransaction(string $params,int $param2=0) :trans
    {
        $result = $this->client->sendRequest("/v1/transaction?txid=".$params."&confirmed=".$param2, [], [], "GET");
        $transaction = new trans($params);
        $transaction->confirmations = ($result['status'])['confirmed']??($result['status'])['unconfirmed'];
        $transaction->inputs = ($result['txn'])['inputs']??array();
        $transaction->outputs = ($result['txn'])['outputs']??array();
        $transaction->time = ($result['time'])??'';
        return $transaction;

    }

    /**
     * @param string $params
     * @return trans
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
//    public function getRawTransaction(string $params) :trans
//    {
//        $data = $this->client->sendRequest("/v1/rawtx?txid=".$params, [], [], "GET");
//        $tran = new \SkyCoin\Transaction();
//        return $tran;
//    }

    /**
     * @return trans
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function resendUnconfirmedTxns(){
        $result = $this->client->sendRequest("/v1/resendUnconfirmedTxns", [], []);
        $transaction = new trans();
        $transaction->unconfirmedTxids= $result['txids'];
        return $transaction;
    }

    /**
     * @param array $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function verify(array $params){
        return $this->client->sendRequest("v2/transaction/verify", $params, []);
    }

    /**
     * @param $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function injectTransaction($params){
        return $this->client->sendRequest("/v1/injectTransaction", $params, []);
    }

}