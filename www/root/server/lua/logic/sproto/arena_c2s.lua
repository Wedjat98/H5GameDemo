--*******************head
local server = require "server"
local lua_app = require "lua_app"
local lua_util = require "lua_util"

--[[
# 请求竞技场数据
cs_arena_info 13001 {
	request {

	}
	response {
        targets		0 : *arena_target_data	#可挑战的目标
        rank		1 : integer				#我的排名
        maxrank		2 : integer				#历史最高排名
        pkcount		3 : integer				#剩余挑战次数
        remaintime	4 : integer				#距离下次回复剩余时间
        buycount	5 : integer				#今天已购买的挑战次数
        medal		6 : integer				#功勋
    }
}
]]
function server.cs_arena_info(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.arena:GetArenaInfo()
end

--[[
# 选择pk目标
cs_arena_pk 13002 {
	request {
		rank		0 : integer			#挑战的目标
	}
}
]]
function server.cs_arena_pk(socketid, msg)
	local player = server.playerCenter:GetPlayerBySocket(socketid)
	player.arena:ArenaPK(msg)
end

--[[
# 领取奖励
cs_arena_get_reward 13003 {
	request {
	}
}
]]
function server.cs_arena_get_reward(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    player.arena:GetReward()
end

--[[
# 购买挑战次数
cs_buy_pk 13004 {
	request {

	}
	response {
		ret 		0 : boolean
		pkcount		1 : integer
		buycount	2 : integer
	}
}
]]
function server.cs_buy_pk(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.arena:BuyPK()
end

--[[
# 竞技排行榜
cs_arena_rank 13005 {
	request {

	}
	response {
		ranklist	0 : *rank_data
	}
}
]]
function server.cs_arena_rank(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return server.arenaCenter:GetArenaRank()
end
