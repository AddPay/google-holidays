<?php

namespace Google\Vendor;

class Holidays
{
    private $api_key;
    private $country_code;
    private $start_date;
    private $end_date;
    private $minimal = false;
    private $dates_only = false;

    public function __construct()
    {
        $this->start_date = date('Y-m-d') . 'T00:00:00-00:00';
        $this->end_date = (date('Y')+1) . '-01-01T00:00:00-00:00';
    }

    public function withApiKey($api_key)
    {
        $this->api_key = $api_key;

        return $this;
    }

    public function inCountry($country_code)
    {
        $this->country_code = strtolower($country_code);

        return $this;
    }

    public function withMinimalOutput()
    {
        $this->minimal = true;

        return $this;
    }

    public function withDatesOnly()
    {
        $this->dates_only = true;

        return $this;
    }

    public function list()
    {
        if (!$this->api_key) {
            throw new \Exception('Providing an API key might be a better start. RTFM.');
        }

        if (!$this->country_code) {
            throw new \Exception('Providing a Country Code is a good idea. RTFM.');
        }

        $result = array();

        $api_url = "https://content.googleapis.com/calendar/v3/calendars/en.{$this->country_code}%23holiday%40group.v.calendar.google.com/events" .
               "?singleEvents=false" .
               "&timeMax={$this->end_date}" .
               "&timeMin={$this->start_date}" .
               "&key={$this->api_key}";

        $response = json_decode(file_get_contents($api_url), true);

        if (isset($response['items'])) {
            if ($this->dates_only === true) {
                foreach ($response['items'] as $holiday) {
                    $result[] = $holiday['start']['date'];
                }

                sort($result);
            } elseif ($this->minimal === true) {
                foreach ($response['items'] as $holiday) {
                    $result[] = array(
                      'name' => $holiday['summary'],
                      'date' => $holiday['start']['date']
                    );
                }

                usort($result, function ($a, $b) {
                    if ($a['date'] == $b['date']) {
                        return 0;
                    }
                    return ($a['date'] < $b['date']) ? -1 : 1;
                });
            } else {
                $result = $response['items'];

                usort($result, function ($a, $b) {
                    if ($a['start']['date'] == $b['start']['date']) {
                        return 0;
                    }
                    return ($a['start']['date'] < $b['start']['date']) ? -1 : 1;
                });
            }
        }

        return $result;
    }
}
