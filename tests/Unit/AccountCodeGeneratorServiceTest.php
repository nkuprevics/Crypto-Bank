<?php

use App\Repositories\BankAccountsRepository\BankAccountsRepository;
use App\Services\BankAccountOperationsService;
use PHPUnit\Framework\TestCase;

class AccountCodeGeneratorServiceTest extends TestCase
{
    public function testGenerateAccountCode()
    {
        $bankAccountsRepository = $this->createMock(BankAccountsRepository::class);
        $accountCodeGeneratorService = new BankAccountOperationsService($bankAccountsRepository);

        for ($i = 0; $i < 70; $i++) {
            $accountCode = $accountCodeGeneratorService->generateAccountCode();

            // Assert that the generated account code is a 16-digit long integer
            $this->assertMatchesRegularExpression('/^\d{16}$/', $accountCode);

            // Assert that the generated account code does not start or end with a 0
            $this->assertDoesNotMatchRegularExpression('/^0|0$/', $accountCode);
        }
    }
}
