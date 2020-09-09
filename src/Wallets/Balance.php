<?php


namespace SkyCoin\Wallets;


class Balance
{
    /**
     * @param string $confirmedCoins
     */
    public function setConfirmedCoins(string $confirmedCoins): void
    {
        $this->confirmedCoins = $confirmedCoins;
    }

    /**
     * @param string $confirmedHours
     */
    public function setConfirmedHours(string $confirmedHours): void
    {
        $this->confirmedHours = $confirmedHours;
    }

    /**
     * @param string $predictedCoins
     */
    public function setPredictedCoins(string $predictedCoins): void
    {
        $this->predictedCoins = $predictedCoins;
    }

    /**
     * @param string $predictedHours
     */
    public function setPredictedHours(string $predictedHours): void
    {
        $this->predictedHours = $predictedHours;
    }
    /**
     * @var string
     */
    private string $confirmedCoins;
    /**
     * @var string
     */
    private string $confirmedHours;
    /**
     * @var string
     */
    private string $predictedCoins;
    /**
     * @var string
     */
    private string $predictedHours;

    /**
     * @return string
     */
    public function getConfirmedCoins(): string
    {
        return $this->confirmedCoins;
    }

    /**
     * @return string
     */
    public function getConfirmedHours(): string
    {
        return $this->confirmedHours;
    }

    /**
     * @return string
     */
    public function getPredictedCoins(): string
    {
        return $this->predictedCoins;
    }

    /**
     * @return string
     */
    public function getPredictedHours(): string
    {
        return $this->predictedHours;
    }


}