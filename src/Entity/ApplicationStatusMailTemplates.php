<?php

/**
 * Aviation
 *
 * @copyright 2020-2021 Cross Solution <http://cross-solution.de>
 * @license   MIT
 */

declare(strict_types=1);

namespace Aviation\Entity;

use Applications\Entity\StatusInterface;
use Organizations\Entity\OrganizationInterface;

/**
 * TODO: description
 *
 * @author Mathias Gelhausen
 * TODO: write tests
 */
class ApplicationStatusMailTemplates
{
    private $templates = [
        StatusInterface::CONFIRMED => [
            'de' => <<<TMPL
                ##anrede_formell##,

                vielen Dank für Ihre Bewerbung, über die wir uns sehr gefreut haben.

                Wir werden uns nach Durchsicht Ihrer Bewerbungsunterlagen wieder mit Ihnen in Verbindung setzen.
                Bis dahin bitten wir Sie um etwas Geduld.
                TMPL,

            'en' => <<<TMPL
                ##salutation_formal##,

                thank you very much for your application which we were delighted to receive.

                We will get in touch with you again after reviewing your application documents.
                Until then, we kindly ask you for a little patience.
                TMPL,
            'en_subject' => 'Your application dated %s',
        ],
        StatusInterface::INQUIRY => [
            'de' => <<<TMPL
                ##anrede_formell##,

                um Ihre Bewerbung bearbeiten zu können, fehlen leider noch Dokumente.

                Wir bitten Sie daher um unverzügliche Nachreichung.

                Sie können die fehlenden Unterlagen auch über folgenden Link nachreichen
                {{link}}
                TMPL,

            'en' => <<<TMPL
                ##salutation_formal##,

                unfortunately there are some documents missing to further process your application,

                Please upload the missing documents here:
                {{link}}
                TMPL,
            'en_subject' => 'Your application dated %s',
        ],
        StatusInterface::REJECTED => [
            'de' => <<<TMPL
                ##anrede_formell##,

                wir möchten uns noch einmal recht herzlich für Ihre Bewerbung und das damit verbundene Interesse an unserem Unternehmen bedanken.

                Aufgrund der zahlreichen qualifizierten Bewerbungen ist uns die Vorauswahl nicht leicht gefallen.

                Bedauerlicherweise hat es für Sie dieses Mal nicht ganz bis ins Ziel gereicht und wir müssen Ihnen heute leider absagen.

                Für Ihre weitere berufliche Zukunft wünschen wir Ihnen alles Gute und viel Erfolg!
                TMPL,
            'en' => <<<TMPL
                ##salutation_formal##,

                we would once again like to thank you sincerely for your application and for the associated interest in our company.

                Due to the high number of qualified applications, taking a screening decision has not been easy for us.

                Unfortunately, you didn't make it to the finish line this time and we have to give you a negative reply today.

                We wish you all the best and good luck for your future career! 
                TMPL,
            'en_subject' => 'Your application dated %s',
        ],
        StatusInterface::INVITED => [
            'de' => <<<TMPL
                ##anrede_formell##,

                die Vorauswahl für die ausgeschriebene Stelle/Funktion ist nun abgeschlossen.

                Im nächsten Schritt möchten wir Sie daher gerne persönlich kennen lernen.

                Zu diesem Zweck laden wir Sie recht herzlich zu einem ersten Vorstellungsgespräch ein:
                TMPL,
            'en' => <<<TMPL
                ##salutation_formal##,

                the screening for the advertised position/function is now complete.

                We are pleased to inform you that your personal and professional profile has piqued our interest.

                As the next step, we would thus like to get to know you personally.To that end, we cordially invite you to a first job interview:
                TMPL,
            'en_subject' => 'Your application dated %s',
        ],
    ];

    private $languagesForOrganizations = [];

    public function __construct(?array $languageMap = null)
    {
        $this->languagesForOrganizations = $languageMap;
    }

    /**
     * @return string[] first item is the mail text, second the mail subject
     */
    public function get(string $status, string $language = 'de'): array
    {
        return [
            $this->templates[$status][$language] ?? '',
            $this->templates[$status][$language . "_subject"] ?? 'Ihre Bewerbung vom %s',
        ];
    }

    /**
     * @return string[] first item is the mail text, second the mail subject
     */
    public function getForOrganization(string $status, OrganizationInterface $organization): array
    {
        $language = $this->languagesForOrganizations[$organization->getId()] ?? 'de';

        return $this->get($status, $language);
    }
}
