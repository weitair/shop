<?php

namespace App\Logics\Api;

use App\Models\MemberAddress as MemberAddressModel;
use Illuminate\Http\Request;

class MemberAddress extends MemberAddressModel
{
    public static function getList()
    {
        $request = Request::capture();
        $type = $request->get('type', 0);

        return Member::user()->address()
            ->where('type', $type)
            ->orderBy('default', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with('member')->findOrFail($id);
    }

    public static function sumbit(array $data)
    {
        $member = Member::user();
        if ($data['default'] == self::DEFAULT_ON) {
            $member->address()
                ->where('type', $data['type'])
                ->update(['default' => self::DEFAULT_OFF]);
        }
        return $member->address()->updateOrCreate(
            ['id' => isset($data['id']) ? $data['id'] : 0],
            $data
        );
    }

    public static function default(int $type)
    {
        return Member::user()
            ->address()
            ->where('default', self::DEFAULT_ON)
            ->where('type', $type)
            ->first();
    }

    public static function remove(int $id)
    {
        return self::destroy($id) > 0;
    }
}
