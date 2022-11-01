<?php

namespace Npl\Ticket;

class Ticket {
    private $lanId;
    private $userId;
    private $seatId;
    private $extras = [];
    private TicketStatus $status;
    private bool $isHelping = false;

    /**
     * @param $lanId
     * @return Ticket
     */
    public static function new($lanId): Ticket
    {
        $ticket = new self($lanId);
        $ticket->status = TicketStatus::NOT_PAID;
        return $ticket;
    }

    /**
     * @param TicketDTO $ticketDTO
     * @return Ticket
     */
    public static function fromDTO(TicketDTO $ticketDTO): Ticket
    {
        if (!$ticketDTO->status instanceof TicketStatus) {
            throw new InvalidTicketStatus('Passed ticket status is not valid');
        }

        $ticket = new self($ticketDTO->lanId);
        $ticket->userId = $ticketDTO->userId;
        $ticket->status = $ticketDTO->status;
        // TODO: Various checks
        return $ticket;
    }

    /**
     * @param $lanId
     */
    private function __construct($lanId)
    {
        $this->lanId = $lanId;
    }

    /**
     * @return mixed
     */
    public function getLanId(): mixed
    {
        return $this->lanId;
    }

    /**
     * @return mixed
     */
    public function getUserId(): mixed
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getSeatId(): mixed
    {
        return $this->seatId;
    }

    /**
     * @return array
     */
    public function getExtras(): array
    {
        return $this->extras;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function isHelping(): bool
    {
        return $this->isHelping;
    }

    /**
     * @return $this
     * @throws OwnerMismatchException
     */
    public function transfer($ownerId, $newOwnerId): static
    {
        if ($ownerId !== $this->userId) {
            throw new OwnerMismatchException('Ticket is not owned by provided owner');
        }

        $this->userId = $newOwnerId;
        return $this;
    }

    /**
     * @param $extra
     * @return $this
     */
    public function addExtra($extra): static
    {
        if (!in_array($extra, $this->extras, true)) {
            $this->extras[] = $extra;
        }

        return $this;
    }

    /**
     * @param $extra
     * @return $this
     */
    public function removeExtra($extra): static
    {
        $extraKey = array_search($extra, $this->extras, true);

        if ($extraKey !== false) {
            array_splice($this->extras, $extraKey, 1);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function markAsPaid(): static
    {
        if ($this->status !== TicketStatus::NOT_PAID) {
            throw new InvalidTicketStatus('Ticket is already marked as paid');
        }

        $this->status = TicketStatus::PAID;
        return $this;
    }

    /**
     * @return $this
     */
    public function markAsPrepaid(): static
    {
        if ($this->status !== TicketStatus::NOT_PAID) {
            throw new InvalidTicketStatus('Ticket is already marked as paid');
        }

        $this->status = TicketStatus::PREPAID;
        return $this;
    }
}
