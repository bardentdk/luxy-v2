<?php

namespace App\Services;

use App\Models\Formation;
use App\Models\FormationCategory;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class FormationService
{
    /**
     * Récupérer toutes les formations publiées avec filtres.
     */
    public function getPublishedFormations(array $filters = []): LengthAwarePaginator
    {
        $query = Formation::with(['category', 'author'])
            ->published()
            ->ordered();

        if (! empty($filters['category'])) {
            $query->whereHas('category', fn($q) => $q->where('slug', $filters['category']));
        }

        if (! empty($filters['level'])) {
            $query->byLevel($filters['level']);
        }

        if (! empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(fn($q) => $q
                ->where('title', 'like', "%{$term}%")
                ->orWhere('short_description', 'like', "%{$term}%")
            );
        }

        return $query->paginate($filters['per_page'] ?? 9);
    }

    /**
     * Récupérer les formations en vedette.
     */
    public function getFeaturedFormations(int $limit = 3): Collection
    {
        return Formation::with(['category'])
            ->published()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Créer une formation.
     */
    public function create(array $data, ?UploadedFile $thumbnail = null, ?UploadedFile $banner = null): Formation
    {
        if ($thumbnail) {
            $data['thumbnail'] = $this->uploadImage($thumbnail, 'formations/thumbnails');
        }
        if ($banner) {
            $data['banner'] = $this->uploadImage($banner, 'formations/banners', 1920, 600);
        }

        $data['author_id']      = auth()->id();
        $data['is_published']   = (bool) ($data['is_published']   ?? false);
        $data['is_featured']    = (bool) ($data['is_featured']    ?? false);
        $data['has_certification'] = (bool) ($data['has_certification'] ?? false);

        // Nettoyer les tableaux
        if (isset($data['objectives'])) {
            $data['objectives'] = array_values(array_filter($data['objectives'], fn($v) => ! empty(trim($v))));
        }
        if (isset($data['prerequisites'])) {
            $data['prerequisites'] = array_values(array_filter($data['prerequisites'], fn($v) => ! empty(trim($v))));
        }

        if (! empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        // Retirer les champs non fillable
        unset($data['_method']);

        return Formation::create($data);
    }

    /**
     * Mettre à jour une formation.
     */
    public function update(Formation $formation, array $data, ?UploadedFile $thumbnail = null, ?UploadedFile $banner = null): Formation
    {
        if ($thumbnail) {
            if ($formation->thumbnail) {
                Storage::disk('public')->delete($formation->thumbnail);
            }
            $data['thumbnail'] = $this->uploadImage($thumbnail, 'formations/thumbnails');
        }

        if ($banner) {
            if ($formation->banner) {
                Storage::disk('public')->delete($formation->banner);
            }
            $data['banner'] = $this->uploadImage($banner, 'formations/banners', 1920, 600);
        }

        $data['is_published']      = (bool) ($data['is_published']      ?? false);
        $data['is_featured']       = (bool) ($data['is_featured']        ?? false);
        $data['has_certification'] = (bool) ($data['has_certification']  ?? false);

        if (isset($data['objectives'])) {
            $data['objectives'] = array_values(array_filter($data['objectives'], fn($v) => ! empty(trim($v))));
        }
        if (isset($data['prerequisites'])) {
            $data['prerequisites'] = array_values(array_filter($data['prerequisites'], fn($v) => ! empty(trim($v))));
        }

        if (! empty($data['is_published']) && ! $formation->published_at) {
            $data['published_at'] = now();
        }

        unset($data['_method']);

        $formation->update($data);
        return $formation->fresh();
    }

    /**
     * Supprimer une formation (soft delete).
     */
    public function delete(Formation $formation): bool
    {
        return $formation->delete();
    }

    /**
     * Uploader et redimensionner une image.
     */
    private function uploadImage(UploadedFile $file, string $directory, int $width = 800, int $height = 600): string
    {
        $filename = uniqid() . '_' . time() . '.webp';
        $path     = $directory . '/' . $filename;

        $image = Image::read($file->getPathname())
            ->cover($width, $height)
            ->toWebp(85);

        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }

    /**
     * Toutes les catégories.
     */
    public function getCategories(): Collection
    {
        return FormationCategory::ordered()->get();
    }
}