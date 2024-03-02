<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories/",
     *     tags={"Categories"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{category}",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category information retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function view(?User $user, Category $category): bool
    {
        return true;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/categories/",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                      @OA\Property(
     *                          property="type",
     *                          type="string",
     *                          example="categories"
     *                          ),
     *                      @OA\Property(
     *                          property="attributes",
     *                          type="object",
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              example=""
     *                          )
     *                      )
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category was created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     * )
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/categories/{category}",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *       name="category",
     *       in="path",
     *       required=true,
     *        @OA\Schema(
     *           type="integer"
     *         )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                      @OA\Property(
     *                          property="type",
     *                          type="string",
     *                          example="categories"
     *                          ),
     *                      @OA\Property(
     *                          property="id",
     *                          type="string",
     *                          example=""
     *                          ),
     *                      @OA\Property(
     *                          property="attributes",
     *                          type="object",
     *                          @OA\Property(
     *                              property="name",
     *                              type="string",
     *                              example=""
     *                          )
     *                      )
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category was created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     * )
     */
    public function update(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/categories/{category}",
     *     tags={"Categories"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Category was deleted",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="internal server error"
     *      )
     * )
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{category}/posts",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="category",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category information retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function viewPosts(?User $user, Category $category): bool
    {
        return true;
    }
}
