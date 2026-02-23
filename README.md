# Plant ID

A web application that identifies plants from photographs using the [PlantNet API](https://plantnet.org/). Upload up to 5 plant photos, specify the plant organ (leaf, flower, bark, fruit, habit, or other), and get instant identification results with confidence scores, scientific names, and reference images.

## Tech Stack

- **Backend:** PHP 8.2+, Laravel 12, Livewire 4
- **Frontend:** TailwindCSS 4, DaisyUI 5, Vite 6
- **API:** PlantNet v2 identification API
- **Image Processing:** Spatie Image Optimizer

## Setup

1. Clone the repository:
   ```bash
   git clone <repo-url> plant-id
   cd plant-id
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Configure environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Set your PlantNet API key in `.env`:
   ```
   PLANT_ID_SECRET=your_plantnet_api_key_here
   ```
   Get an API key at https://my.plantnet.org/

5. Set up the database:
   ```bash
   php artisan migrate
   ```

6. Build frontend assets:
   ```bash
   npm run dev
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

1. Navigate to `/plantId`
2. Upload a photo of a plant (JPEG or PNG, max 6.25MB)
3. Select the plant organ shown in the photo (leaf, flower, bark, fruit, habit, or other)
4. Optionally add more photos (up to 5) for better accuracy
5. Click "Identify" to get results

Results display confidence scores, common and scientific names, and reference images from the PlantNet database.

## Testing

```bash
php artisan test
```

## License

MIT
