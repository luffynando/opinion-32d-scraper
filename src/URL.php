<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper;

final class URL
{
    public const LOGIN_URL = 'https://login.mat.sat.gob.mx/nidp/app/login?id=contr-dual-totp-eFirma&sid=0&option=credential&sid=0';
    public const LOGOUT_URL = 'https://ptsc32d.clouda.sat.gob.mx/Cuenta/Logout';
    public const MAIN_URL = 'https://ptsc32d.clouda.sat.gob.mx/?/reporteOpinion32DContribuyente';
}
