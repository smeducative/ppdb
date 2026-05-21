<?php

namespace Tests\Feature;

use App\Http\Requests\DocumentFilterRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_tahun_filter_rejects_non_integer_input(): void
    {
        $this->expectException(ValidationException::class);

        $this->validateFilterRequest(['tahun' => 'abc']);
    }

    public function test_tahun_filter_rejects_year_below_lower_bound(): void
    {
        $this->expectException(ValidationException::class);

        $this->validateFilterRequest(['tahun' => 1899]);
    }

    public function test_tahun_filter_rejects_year_above_upper_bound(): void
    {
        $this->expectException(ValidationException::class);

        $this->validateFilterRequest(['tahun' => now()->year + 2]);
    }

    public function test_tahun_filter_accepts_current_year(): void
    {
        $validated = $this->validateFilterRequest(['tahun' => now()->year]);

        $this->assertSame(now()->year, $validated['tahun']);
    }

    public function test_tahun_filter_allows_missing_value(): void
    {
        $validated = $this->validateFilterRequest([]);

        $this->assertArrayNotHasKey('tahun', $validated);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function validateFilterRequest(array $payload): array
    {
        $request = DocumentFilterRequest::create('/dashboard', 'GET', $payload);
        $request->setContainer(app())->setRedirector(app('redirect'));
        $request->validateResolved();

        return $request->validated();
    }
}
