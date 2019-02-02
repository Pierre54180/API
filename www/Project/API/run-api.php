<?php
/**
 * @apiGroup Categories
 * @apiName GetCategories
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id  accès a une ressource catégorie
 *
 * @apiDescription Accès a une ressource de type catégorie
 * permet d'accéder à la représentation d'une ressource categorie .
 * Retourne une représentation json de la ressource, incluant son nom et
 * id.
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *	  {
 *	      
 *    }
 *
*/

/**
 * @apiGroup Categories
 * @apiName GetAllCategories
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/  accès au ressource catégorie
 *
 * @apiDescription Accès au ressource de type catégorie
 * permet d'accéder à la représentation de toute les ressources categories .
 * Retourne une représentation json de la ressource, incluant son nom et
 * id.
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *	   {
 *	      "nb": 5,
 *		  "categories": [ 
 *            {
 *              "id": 1,
 *              "nom": "salades"
 *            },
 *            {
 *              "id": 2,
 *              "nom": "crudités"
 *            },
 *            {
 *              "id": 3,
 *              "nom": "viandes"
 *            },
 *            {
 *              "id": 4,
 *              "nom": "Fromages"
 *            },
 *            {
 *              "id": 5,
 *              "nom": "Sauces"
 *            }
 *       ]
 *    }
 *
*/

/**
 * @apiGroup Categories
 * @apiName GetCategorie
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id  accès à une ressource catégorie
 *
 * @apiDescription Accès à une ressource de type catégorie
 * permet d'accéder à la représentation de la ressource categorie désignée.
 * Retourne une représentation json de la ressource, incluant son nom et
 * sa description.
 *
 * Le résultat inclut un lien pour accéder à la liste des ingrédients de cette catégorie.
 *
 * @apiParam {Number} id Identifiant unique de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de la catégorie
 * @apiSuccess (Succès : 200) {String} nom Nom de la catégorie
 * @apiSuccess (Succès : 200) {String} description Description de la catégorie
 * @apiSuccess (Succès : 200) {Link}   links-ingredients lien vers la liste d'ingrédients de la catégorie
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *            "id"  : 4 ,
 *            "nom" : "crudités",
 *            "description" : "nos salades et crudités fraiches et bio."
 *        },
 *        links : {
 *            "ingredients" : { "href" : "/categories/4/ingredients }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) CategorieNotFound Categorie inexistante
 *
 * @apiErrorExample {json} exemple de réponse en cas d'erreur
 *     HTTP/1.1 404 Not Found
 *
 *     {
 *       "error": "ressource not found : /VMProject/php.iut.local/php.iut.local/www/Project/api/categories/50"
 *     }
*/

/**
 * @apiGroup Categories
 * @apiName GetCategingredients
 * @apiVersion 0.1.0
 *
 * @api {get} /categories/id/ingredients  accès au ressource ingrédients d'une catégorie
 *
 * @apiDescription Accès au ressource de type ingrédients
 * permet d'accéder à la représentation des ressources ingrédients de la categorie désignée.
 * Retourne une représentation json de la ressource, incluant son id, nom, id de la catégorie, 
 * sa description, fournisseur et image.
 *
 *
 * @apiParam {Number} id Identifiant unique de la catégorie
 *
 *
 * @apiSuccess (Succès : 200) {Number} id Identifiant de l'ingrédient
 * @apiSuccess (Succès : 200) {String} nom Nom de l'ingrédient
 * @apiSuccess (Succcé : 200) {Number} cat_id Identifiant de la catégorie
 * @apiSuccess (Succcé : 200) {String} description Description de l'ingrédient
 * @apiSuccess (Succcé : 200) {String} fournisseur Nom du fournisseur de l'ingrédient
 * @apiSuccess (Succcé : 200) {String} img Image de l'ingrédient
 *
 *
 * @apiSuccessExample {json} exemple de réponse en cas de succès
 *     HTTP/1.1 200 OK
 *
 *     {
 *        categorie : {
 *            "id"  : 4 ,
 *            "nom" : "crudités",
 *            "description" : "nos salades et crudités fraiches et bio."
 *        },
 *        links : {
 *            "ingredients" : { "href" : "/categories/4/ingredients }
 *        }
 *     }
 *
 * @apiError (Erreur : 404) CategorieNotFound Categorie inexistante
 *
 * 
*/