<?php
use PHPUnit\Framework\TestCase;
use InfraDigital\ApiClient;

class ClientTest extends TestCase
{
    protected $username = '10001';
    protected $password = '123';

    public function testClientInstanceOf()
    {
        $this->assertInstanceOf(
            ApiClient\ClientInterface::class,
            new ApiClient\Client($this->username, $this->password)
        );
    }

    public function testCreateStudent()
    {
        $idnClient = new ApiClient\Client($this->username, $this->password);
        $idnClient->setDevMode();
        $idnClient->studentApi()->createStudent('Test User 1234' . date('YMDhis'), 'testBillKey01234' . date('YMDhis'),'0987612345', 'use.only@valid.domain', 'This is test to create user');
        $this->assertEquals(201, $idnClient->studentApi()->getResponseCode());

    }

    public function testCreateStudents()
    {
        $idnClient = new ApiClient\Client($this->username, $this->password);
        $idnClient->setDevMode();
        $idnClient->studentApi()->createStudents($this->studentsData());
        $this->assertEquals(201, $idnClient->studentApi()->getResponseCode());
    }

    public function testCreateStudentsUsingAppend()
    {
        $idnClient = new ApiClient\Client($this->username, $this->password);
        $idnClient->setDevMode();
        foreach ($this->studentsData() as $student) {
            $idnClient->studentApi()->appendStudentData(
                $student['name'],
                $student['billKeyValue'],
                $student['phone'],
                $student['email'],
                $student['description']);

        }
        $idnClient->studentApi()->createStudents();
        $this->assertEquals(201, $idnClient->studentApi()->getResponseCode());
    }

    public function testCreateBilling()
    {
        $idnClient = new ApiClient\Client($this->username, $this->password);
        $idnClient->setDevMode();
        $idnClient->studentApi()->createBill('Test User 123', '123' . date('YMDhis'), '08123123456', 'use.only@valid.email', 'Testing', $this->billingData());
        $this->assertEquals(201, $idnClient->studentApi()->getResponseCode());
    }

    private function studentsData()
    {
        return array(
            array(
                'name' => 'test User 0001' . date('YMDhis'),
                'billKeyValue' => '0001'. date('YMDhis'),
                'phone' => '081231230001',
                'email' => 'use.only@valid.domain',
                'description' => 'Testing user #0001',
            ),
            array(
                'name' => 'test User 0002' . date('YMDhis'),
                'billKeyValue' => '0002' . date('YMDhis'),
                'phone' => '081231230002',
                'email' => 'use.only@valid.domain',
                'description' => 'Testing user #0002',
            ),
            array(
                'name' => 'test User 0003' . date('YMDhis'),
                'billKeyValue' => '0003' . date('YMDhis'),
                'phone' => '081231230003',
                'email' => 'use.only@valid.domain',
                'description' => 'Testing user #0003',
            ),
        );
    }

    private function billingData()
    {
        $time = strtotime('now +1 month');
        $newTime = date('Y-m-d\TH:i:s\Z',$time);
        return array(
            array(
                'account_code' => "MANDIRI",
                'bill_component_name' => 'Test',
                'expiry_date' => $newTime,
                'due_date' => $newTime,
                'active_date' => '2017-11-30T00:00:00Z',
                'amount' => 10000,
                'penalty_amount' => 10000,
                'description' => 'Testing',
            )
        );
    }
}