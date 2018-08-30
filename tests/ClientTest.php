<?php
use PHPUnit\Framework\TestCase;
use InfraDigital\ApiClient;

class ClientTest extends TestCase
{
    protected $username = '10014';
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
}