<?php
declare(strict_types=1);

namespace App\Tests\functional\api\v1;

use Codeception\Example;
use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthCest
 *
 * @package App\Tests\functional\api\v1
 */
class AuthCest
{
    /**
     * @dataProvider validJwtProvider
     *
     * @param FunctionalTester $I
     * @param Example          $example
     */
    public function canPassAuthorizationWithValidJwt(FunctionalTester $I, Example $example)
    {
        $I->haveHttpHeader('Authorization', sprintf('Bearer %s', $example['jwt']));
        $I->sendGET('/v1/characters');
        $I->seeResponseCodeIs(Response::HTTP_OK);
    }

    /**
     * @dataProvider invalidJwtProvider
     *
     * @param FunctionalTester $I
     * @param Example          $example
     */
    public function cannotPassAuthorizationWithInvalidJwt(FunctionalTester $I, Example $example)
    {
        $I->haveHttpHeader('Authorization', sprintf('Bearer %s', $example['jwt']));
        $I->sendGET('/v1/characters');
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotPassAuthorizationWithoutHttpHeader(FunctionalTester $I)
    {
        $I->sendGET('/v1/characters');
        $I->seeResponseCodeIs(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return array
     */
    protected function validJwtProvider(): array
    {
        return [
            // valid for 100 years
            ['jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTI4NzAzMjMsImV4cCI6NDc0NjQ3MDMyMywicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.hMmINVUyiiYVMTb2rgSWvZI_F4Ws3uIe3niCWSdNO-5rrjFYG75dWn4abFrhcopTZycva8RdA3oE8D5MigABp4jRqRFB8F00MX7eRoQ8L94lZF4f6pg91dzdiOTkm4cAS6cy-EQ57kSuFjS7PhzL_dVcxgDInknhy3AT8YhuFU1htPYzNcjIyFoNbzvCdC0WgwxBy53wdS-uaR7n1QWxApkz0MO3BwV86L5977oprm_mrvcoab5kCOBO3ygIw3Ux57Lc5bRWlME8ZwuIzcl_UUsXm3_129zyETJFl5kin78ZzBKFEbWvZ5FlKKXYbUCTuf1zOng3FIFW8uFqNIAgA4BH4hY269_df4P4iTRTCZJy9Yq_3CbOPDoSSzC6J7JHou_XFM0CrihTiVlrvKjHy0J_J3NdLLG2EoQYfMvU34HttLd2agumx2P2pDXmLxQaqCYEXimHotFpn94w1emCsrbUoiKHNmzsYNdWL-rv6LIRLnWRLeQuef4aNgZodAE4hXCb50jNjX6qjX6YIxq04p4P-gopXDRjDBtBELt_2Ymlfo0FosLrbVa1SxdeOJQk4CkZvAPqcvj-sjT9By2S1cpqJG9S5fNko9OlWMILOxVNs2OZgyKpY623o64NAoRYWwiqt8w6AF_L114MXvYrkCezfZDZba1kp-tbRfXpyXk'],
        ];
    }

    /**
     * @return array
     */
    protected function invalidJwtProvider(): array
    {
        return [
            ['jwt' => ''],
            ['jwt' => 'qwerty'],
            // expired
            ['jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTI4NzAxOTksImV4cCI6MTU5Mjg3MDIwMCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.ltd0CmCJ9Zy2s868sbsSUVocN8fR5pDSLDeh7o8l23MLYkHMaKEXIJg3-VyFyB65OVj4L_5x2IxMmmi9LYqdSs5G9dya4jJGLsLWFGI3q_h6qhwWvpLJnbrLclUtJKjnkq3uz6QzWSZ7nx7XAexOSCgLu9BfgI10ECJXRAgyJhDFZn2HsQtxnzcMWvrehDCaGZWuGUrxD4CGdiL8a7wsVtXsG_6oguhlFBnmdS7FmbunOfaDBnLNuzS_SLyTmVUAqQtQUPm5S10GJI8pKYQIfREL4zgcrpnwiG1VxNGq2Vva9Lc5CNhf9iG_ly3rBn4Fx76H03w-qByOrsjK3T2oQwwN9ETyoXyXaYFJ9SRI1lP5N7L_8sLW5O6P-Kika-lPXVYDke076UqMK5SM0Of9juIYmr1IcTEyfL-GlEHRR7KUZsxGioU3lOIfIEPhewBmFCdIdR5XS5V3N0P5uUmJ05pN1s-mFuUwU1y1P_R-7Rv-u5B15etLbRNsUMyDcHXuQnte-TfTAv7TqoZH2qv4tu13OotWAcsh4S3vdJiCHgoByVD6sYgbiCM8Lp8XQGzcFcOqm449vpyeDm8scA_Y9pxcEqYVrJhBlUXM4m4InjmHUKqHR9cjpdLjp4DfM-ZOMBHe_Oao73M9cBUPUjPshh3Lx7L_y9uTYwJCw2ZfWU0'],
            // created with invalid key (=> invalid signature), valid for 100 years
            ['jwt' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1OTI4Njk5ODUsImV4cCI6MTYwMTUwOTk4NSwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoidXNlciJ9.nggSmF4k_BMxcUXBpNorAjkdioayDcJQKIViUNlZlf2Ji9dzYYYYj_5O3Spa0nUlb_5qKgFTEg4v-4r-yRIh5ITQemRkM1bYmhhBnbJAsoLZd1K0WiXiJosEXgMQ4uuEN8CtnYmg93Lxn3lnupNAFSlkhaEWL6QqaZV3uV_5kbfKjmuih3SAB5YK3p9269vhJet-cQBrIp432M42Osmt9VoJjO0qBXSM-ypxqmT59CZ0ZJblhntkzF0OGjBtHUN35QunOoZRT_ZJAYWuJ5H0hHCvFH_9uNW8jUxvtjMadcWwDL_v196otPyzWe-Jk9KPrWDoMUMvP6rB2wYKyHNm6x43WASXfzcdIfHXwzjOisTDGOgx_RVEHjz926DJ-z978JBhGsv5BHlb5dyVj1EceBFsiRr6QA3bBrPTwhLrJH1JhulOsS8t44x94Xhi6PFx2Bql2fKZAvZdUGN8TPHKomwdOB7oZ8YeHlThG4WxAqpPfunPnCldqu1Qe-tXO5T5zEWj1czdW8JS6TqfAKLW8njLqN6KwT22GLlQjMJIeB3ZRltmnMv2XVhZfuF-OJy_dscp6-3HiQC1YSslJebA8KOty35v1lnlJ0CB2plA89S1RdeFh10SPL7qCwiOzMR8UPfECg8GRQLkJLhTldPs5o02gvlRvM3rgJXIBfqAsUE'],
        ];
    }
}