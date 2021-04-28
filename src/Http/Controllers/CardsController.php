<?php

namespace Src\Http\Controllers;

class CardsController extends CommonController
{
    /**
     * Sort data.
     *
     * @param array $data
     * @return array
     */
    public static function sort(array $data): array
    {
        $cardsWithFromAndTo = self::withFromAndTo($data);
        $filteredCards = self::filterByFromAndTo($cardsWithFromAndTo);
        $orderedCardsWithFromData = self::getOrderedCards($cardsWithFromAndTo);

        usort($filteredCards, function ($a, $b) use ($orderedCardsWithFromData) {
            $posA = array_search($a['from'], $orderedCardsWithFromData);
            $posB = array_search($b['from'], $orderedCardsWithFromData);

            return $posA - $posB;
        });

        $allCards = self::addFinalCard($cardsWithFromAndTo, $filteredCards);

        return array_map(function ($card) {
            return $card['text'];
        }, $allCards);
    }

    /**
     * Filter By From And To
     *
     * @param  array $cards
     * @return array
     */
    private static function filterByFromAndTo(array $cards): array
    {
        return array_filter($cards, function ($v) {
            return $v['from'] && $v['to'];
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Get Array With From And To
     *
     * @param  array $boardingCards
     * @return array
     */
    private static function withFromAndTo(array $boardingCards): array
    {
        $arrayWithFromAndTo = [];

        foreach ($boardingCards as $boardingCard) {
            $arrayWithFromAndTo[] = array_merge(['text' => $boardingCard], self::getFromAndToFromString($boardingCard));
        }

        return $arrayWithFromAndTo;
    }

    /**
     * Get Ordered Cards
     *
     * @param  array $cards
     * @return array
     */
    private static function getOrderedCards(array $cards): array
    {
        $fromArray = []; // all 'from' data of card list
        $toArray = []; // all 'to' data of card list
        $allCards = []; // all cards in format [from => to]

        foreach ($cards as $card) {
            $fromArray[] = $card['from'];
            $toArray[] = $card['to'];
            $allCards[$card['from']] = $card['to'];
        }

        $firstPoint = array_merge([], array_diff($fromArray, $toArray))[0]; //get the first point

        return self::getOrderedCardsByFrom($firstPoint, $allCards);
    }

    /**
     * Add Final Card
     *
     * @param  array $cards
     * @param  array $filteredCards
     * @return array
     */
    private static function addFinalCard(array $cards, array $filteredCards): array
    {
        $finalCard = [];

        foreach ($cards as $card) {
            if (!$card['from'] && !$card['to']) {
                $finalCard = $card;
            }
        }

        array_push($filteredCards, $finalCard);

        return $filteredCards;
    }

    /**
     * Get Ordered Boarding Cards By From.
     *
     * @param string $from
     * @param array $boardingCards
     * @param array $boardingCardFromArray
     * @return array
     */
    private static function getOrderedCardsByFrom(
        string $from,
        array $boardingCards,
        array $boardingCardFromArray = []
    ) {
        if (isset($boardingCards[$from]) && $boardingCards[$from]) {
            array_push($boardingCardFromArray, $from);

            return self::getOrderedCardsByFrom($boardingCards[$from], $boardingCards, $boardingCardFromArray);
        }

        return $boardingCardFromArray;
    }

    /**
     * Get From And To From String
     *
     * @param  string $string
     * @return array
     */
    private static function getFromAndToFromString(string $string): array
    {
        $betweenStr = self::findBetween($string, 'from ', '.');
        //get "To" string
        $toPosition = strpos($betweenStr, "to ");
        $to = substr($betweenStr, ($toPosition + 3));

        //get "From" string
        $commaPosition = strpos($betweenStr, ",");
        if (!$commaPosition) {
            $from = substr($betweenStr, 0, ($toPosition - 1));
        } else {
            $from = substr($betweenStr, 0, ($commaPosition));
        }

        return ['from' => $from, 'to' => $to];
    }

    /**
     * Finds a substring between two strings
     *
     * @param  string $string The string to be searched
     * @param  string $start The start of the desired substring
     * @param  string $end The end of the desired substring
     * @return string
     */
    private static function findBetween(string $string, string $start, string $end)
    {
        $start = preg_quote($start, '/');
        $end   = preg_quote($end, '/');
        $format = '/(%s)(.*?)(%s)/i';
        $pattern = sprintf($format, $start, $end);
        preg_match($pattern, $string, $matches);

        if (isset($matches[2]) && $matches[2]) {
            return $matches[2];
        } else {
            return '';
        }
    }
}
