
<?php

class Mahasiswa
{
    private int $id;
    private string $nim;
    private string $nama;
    private int $prodi_id;
    private string $angkatan;
    private string $status;
    private ?int $dosen_id;

    public function __construct(
        string $nim = '',
        string $nama = '',
        int $prodi_id = 0,
        string $status = 'aktif',
        ?int $dosen_id = null
    ) {
        $this->nim = '';
        $this->nama = '';
        $this->prodi_id = 0;
        $this->angkatan = '';
        $this->dosen_id = null;

        if ($nim !== '') {
            $this->setNim($nim);
        }

        if ($nama !== '') {
            $this->setNama($nama);
        }

        if ($prodi_id > 0) {
            $this->setProdi($prodi_id);
        }

        $this->setStatus($status);
        $this->setDosenId($dosen_id);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNim(): string
    {
        return $this->nim;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getProdi(): int
    {
        return $this->prodi_id;
    }

    public function getAngkatan(): string
    {
        return $this->angkatan;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDosenId(): ?int
    {
        return $this->dosen_id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNim(string $nim): void
    {
        if ($nim === '' || !ctype_digit($nim)) {
            throw new InvalidArgumentException(
                'NIM harus berupa angka.'
            );
        }

        $this->nim = $nim;

        if (strlen($nim) >= 2) {
            $this->setAngkatan(
                '20' . substr($nim, 0, 2)
            );
        }
    }

    public function setNama(string $nama): void
    {
        $nama = trim($nama);

        if ($nama === '') {
            throw new InvalidArgumentException(
                'Nama tidak boleh kosong.'
            );
        }

        $this->nama = $nama;
    }

    public function setProdi(int $prodi_id): void
    {
        if ($prodi_id <= 0) {
            throw new InvalidArgumentException(
                'Program studi harus dipilih.'
            );
        }

        $this->prodi_id = $prodi_id;
    }

    public function setAngkatan(string $angkatan): void
    {
        $this->angkatan = $angkatan;
    }

    public function setStatus(string $status): void
    {
        if (!in_array(
            $status,
            ['aktif', 'cuti', 'lulus'],
            true
        )) {
            throw new InvalidArgumentException(
                'Status tidak valid.'
            );
        }

        $this->status = $status;
    }

    public function setDosenId(?int $dosen_id): void
    {
        if ($dosen_id !== null && $dosen_id <= 0) {
            throw new InvalidArgumentException(
                'ID dosen tidak valid.'
            );
        }

        $this->dosen_id = $dosen_id;
    }
}