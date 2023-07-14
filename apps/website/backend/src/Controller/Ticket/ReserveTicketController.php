<?php

/*
 * This file is part of the noprobLAN Website.
 *
 * Copyright (c) 2023 Fabian Schweizer <fa.schweizer@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Npl\Apps\Website\Backend\Controller\Ticket;

use Exception;
use InvalidArgumentException;
use Npl\LanOrganisation\Application\LanDoesNotExistException;
use Npl\LanOrganisation\Application\ReserveTicket\ReserveTicketRequest;
use Npl\LanOrganisation\Application\ReserveTicket\ReserveTicketService;
use Npl\LanOrganisation\Domain\Model\Ticket\UserHasAlreadyEnoughTicketsException;
use Npl\Shared\Application\NoPermissionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReserveTicketController extends AbstractController
{
    public function __construct(private readonly ReserveTicketService $service)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $session = $request->getSession();
            $userId = (string)$session->get('userId');

            if (!$userId) {
                return new JsonResponse(
                    [
                        'status' => 'error',
                        'message' => 'Unauthenticated'
                    ],
                    401
                );
            }

            $ticketRequest = new ReserveTicketRequest(
                $userId,
                $request->request->getString('lanId')
            );

            $ticketResponse = $this->service->execute($ticketRequest);

            return new JsonResponse(
                [
                    'status' => 'success',
                    'data' => [
                        'ticketId' => $ticketResponse->getTicketId()
                    ]
                ],
                201
            );
        } catch (InvalidArgumentException $exception) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ]
            );
        } catch (LanDoesNotExistException) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => 'Invalid lan id provided'
                ]
            );
        } catch (UserHasAlreadyEnoughTicketsException) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => 'Max number of tickets reached'
                ]
            );
        } catch (NoPermissionException) {
            return new JsonResponse(
                [
                    'status' => 'error',
                    'message' => 'Unauthorized'
                ],
                403
            );
        } catch (Exception) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ],
                500
            );
        }
    }
}
