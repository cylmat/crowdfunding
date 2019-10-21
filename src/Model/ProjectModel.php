<?php

namespace Model;

class ProjectModel
{
    /*
     * Retourne le pourcentage récolté
     */
    static function getDonatorPercent(string $fonds_actuels, string $fonds_necessaires): int
    {
        return (int)$fonds_necessaires / $fonds_actuels * 100;
    }

    /*
     * Retourne le nombre de jours restants 
     */
    static function getDaysToEnd(string $max_date): int
    {
        $max = new \DateTime($max_date);
        $inter = $max->diff(new \DateTime(), true);
        return (int)$inter->format("%a");
    }

    static function getCategory(string $category_num)
    {
        return \Model\CategoryModel::LIST[$category_num];
    }
}