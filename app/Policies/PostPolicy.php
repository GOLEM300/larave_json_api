<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\User;
use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Relations\HasMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class PostPolicy
{
    /**
     * @OA\Get(
     *     path="/api/v1/posts/",
     *     tags={"Posts"},
     *          @OA\Parameter(
     *          name="filter[search]",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example=""
     *          )
     *      ),
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
     *     path="/api/v1/posts/{post}",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post information retrieved successfully",
     *     ),
     *          @OA\Response(
     *          response=401,
     *          description="Post not found"
     *      ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     ),
     *     @OA\Response(
     *           response=500,
     *           description="internal server error"
     *       )
     * )
     */
    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->is($post->author) or $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $this->update($user, $post);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        //
    }

    /**
     * Determine whether the user can view the post's author.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Post $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAuthor(?User $user, Post $post)
    {
        return $this->view($user, $post);
    }

    /**
     * Determine whether the user can view the post's comments.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Post $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewComments(?User $user, Post $post)
    {
        return $this->view($user, $post);
    }

    /**
     * Determine whether the user can view the post's tags.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Post $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewTags(?User $user, Post $post)
    {
        return $this->view($user, $post);
    }


    /**
     * Determine whether the user can update the model's tags relationship.
     *
     * @param User $user
     * @param Post $post
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function updateTags(User $user, Post $post)
    {
        return $this->update($user, $post);
    }

    /**
     * Determine whether the user can attach tags to the model's tags relationship.
     *
     * @param User $user
     * @param Post $post
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function attachTags(User $user, Post $post)
    {
        return $this->update($user, $post);
    }

    /**
     * Determine whether the user can detach tags from the model's tags relationship.
     *
     * @param User $user
     * @param Post $post
     * @return bool|\Illuminate\Auth\Access\Response
     */
    public function detachTags(User $user, Post $post)
    {
        return $this->update($user, $post);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/posts/{post}/categories",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post information retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function viewCategories(?User $user, Post $post)
    {
        return true;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/posts/{post}/relationships/categories",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                             property="type",
     *                             type="string",
     *                             example="categories"
     *                             ),
     *                          @OA\Property(
     *                            property="id",
     *                            type="string",
     *                            example=""
     *                            ),
     *                          ),
     *                       )
     *                  ),
     *              ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post information retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function attachCategories(User $user, Post $post)
    {
        return $this->update($user, $post);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/posts/{post}/relationships/categories",
     *     tags={"Posts"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="post",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *          @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/vnd.api+json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="data",
     *                      type="array",
     *                      @OA\Items(
     *                          type="object",
     *                          @OA\Property(
     *                             property="type",
     *                             type="string",
     *                             example="categories"
     *                             ),
     *                          @OA\Property(
     *                            property="id",
     *                            type="string",
     *                            example=""
     *                            ),
     *                          ),
     *                       )
     *                  ),
     *              ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post information retrieved successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function detachCategories(User $user, Post $post)
    {
        return $this->update($user, $post);
    }


    /**
     * Build an index query for this resource.
     *
     * @param Request|null $request
     * @param Builder $query
     * @return Builder
     */
    public function indexQuery(?Request $request, Builder $query): Builder
    {
        if ($user = optional($request)->user()) {
            return $query->where(function (Builder $q) use ($user) {
                return $q->whereNotNull('published_at')->orWhere('author_id', $user->getKey());
            });
        }

        return $query->whereNotNull('published_at');
    }
}
