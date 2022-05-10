<?php
namespace Cooking;

class Plugin
{


    public function __construct() 
    {

        add_action(
            'init',
            [$this, 'createRecipePostType']
        );

        add_action(
            'init',
            [$this, 'createIngredientCustomTaxonomy']
        );

        add_action(
            'init',
            [$this, 'createRecipeTypeCustomTaxonomy']
        );

        add_action(
            'init',
            [$this, 'createRecipeDifficultyCustomTaxonomy']
        );

    }

    public function activate()
    {
        $this->registerChefRole();


        $this->createRecipePostType();
        $this->createRecipeDifficultyCustomTaxonomy();

        wp_insert_term('Facile', 'difficulty');
        wp_insert_term('Moyen', 'difficulty');
        wp_insert_term('Difficile', 'difficulty');
        wp_insert_term('Chef', 'difficulty');
    }


    public function createRecipePostType()
    {
        register_post_type(
            'recipe',
            [
                'label' => 'Recette',
                'public' => true,
                'hierarchical' => false,
                'menu_icon' => 'dashicons-food',
                'supports' => [
                    'title',
                    'thumbnail',
                    'editor',
                    'author',
                    'excerpt',
                    // WARNING pour que les commentaires remontent dans l'API, ne pas oublier d'activer la "feature" comments
                    'comments',
                ],
                'capability_type' => 'post',
                'map_meta_cap' => true,

                // IMPORTANT WP le cpt recipe est accessible depuis l'api wordpress
                'show_in_rest' => true
            ]
        );
    }

    public function createRecipeDifficultyCustomTaxonomy()
    {
        register_taxonomy(
            'difficulty',
            ['recipe'],
            [
                'label' => 'Difficulté',
                'hierarchical' => false,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function createIngredientCustomTaxonomy()
    {
        register_taxonomy(
            'ingredient',
            ['recipe'],
            [
                'label' => 'Ingrédient',
                'hierarchical' => true,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function createRecipeTypeCustomTaxonomy()
    {
        register_taxonomy(
            'recipe-type',
            ['recipe'],
            [
                'label' => 'Type de recette',
                'hierarchical' => false,
                'public' => true,
                'show_in_rest' => true
            ]
        );
    }

    public function deactivate()
    {
        remove_role('chef');
    }

    public function registerChefRole()
    {
        add_role(
            'chef',
            'Chef Cuisinier'
        );
    }

}
