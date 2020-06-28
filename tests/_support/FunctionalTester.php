<?php

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    public function amJwtAuthenticated()
    {
        $token   = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTI4NzAzMjMsImV4cCI6NDc0NjQ3MDMyMywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.hMmINVUyiiYVMTb2rgSWvZI_F4Ws3uIe3niCWSdNO-5rrjFYG75dWn4abFrhcopTZycva8RdA3oE8D5MigABp4jRqRFB8F00MX7eRoQ8L94lZF4f6pg91dzdiOTkm4cAS6cy-EQ57kSuFjS7PhzL_dVcxgDInknhy3AT8YhuFU1htPYzNcjIyFoNbzvCdC0WgwxBy53wdS-uaR7n1QWxApkz0MO3BwV86L5977oprm_mrvcoab5kCOBO3ygIw3Ux57Lc5bRWlME8ZwuIzcl_UUsXm3_129zyETJFl5kin78ZzBKFEbWvZ5FlKKXYbUCTuf1zOng3FIFW8uFqNIAgA4BH4hY269_df4P4iTRTCZJy9Yq_3CbOPDoSSzC6J7JHou_XFM0CrihTiVlrvKjHy0J_J3NdLLG2EoQYfMvU34HttLd2agumx2P2pDXmLxQaqCYEXimHotFpn94w1emCsrbUoiKHNmzsYNdWL-rv6LIRLnWRLeQuef4aNgZodAE4hXCb50jNjX6qjX6YIxq04p4P-gopXDRjDBtBELt_2Ymlfo0FosLrbVa1SxdeOJQk4CkZvAPqcvj-sjT9By2S1cpqJG9S5fNko9OlWMILOxVNs2OZgyKpY623o64NAoRYWwiqt8w6AF_L114MXvYrkCezfZDZba1kp-tbRfXpyXk';
        $this->haveHttpHeader('Authorization', sprintf('Bearer %s', $token));
        $this->haveHttpHeader('Content-Type', 'application/json');
    }
}
