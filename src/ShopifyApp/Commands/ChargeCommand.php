<?php

namespace OhMyBrew\ShopifyApp\Commands;

use OhMyBrew\ShopifyApp\DTO\ChargeDTO;
use OhMyBrew\ShopifyApp\Interfaces\IChargeCommand;
use OhMyBrew\ShopifyApp\Interfaces\IChargeQuery;
use OhMyBrew\ShopifyApp\Models\Charge;

/**
 * Reprecents the commands for charges.
 */
class ChargeCommand implements IChargeCommand
{
    /**
     * The querier.
     *
     * @var IChargeQuery
     */
    protected $query;

    /**
     * Init for charge command.
     */
    public function __construct(IChargeQuery $query)
    {
        $this->query = $query;
    }

    /**
     * {@inheritDoc}
     */
    public function createCharge(ChargeDTO $chargeObj): int
    {
        $charge = new Charge();
        $charge->shop_id = $chargeObj->shopId;
        $charge->charge_id = $chargeObj->chargeId;
        $charge->type = $chargeObj->chargeType;
        $charge->status = $chargeObj->chargeStatus;
        $charge->billing_on = $chargeObj->billingOn;
        $charge->activated_on = $chargeObj->activatedOn;
        $charge->trial_ends_on = $chargeObj->trialEndsOn;
        $charge->name = $chargeObj->planDetails->name;
        $charge->price = $chargeObj->planDetails->price;
        $charge->name = $chargeObj->planDetails->name;
        $charge->test = $chargeObj->planDetails->test;
        $charge->trial_days = $chargeObj->planDetails->trialDays;
        $charge->capped_amount = $chargeObj->planDetails->cappedAmount;
        $charge->terms = $chargeObj->planDetails->cappedTerms;

        // Save the charge
        $charge->save();
        
        return $charge->id;
    }

    /**
     * {@inheritDoc}
     */
    public function deleteCharge(int $shopId, int $chargeId): bool
    {
        $charge = $this->chargeQuery->getByShopIdAndChargeId($shopId, $chargeId);
        if (!$charge) {
            return false;
        }

        return $charge->delete();
    }
}