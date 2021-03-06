--*******************head
local server = require "server"
local lua_app = require "lua_app"
local lua_util = require "lua_util"

--[[
#客户端->服务端
#打造
cs_spellsRes_make 5401 {
	request {
		makeType		0 : integer #洗练类型,1普通,2完美,普通不用带自动购买
		autoBuy			1 : integer #0不自动购买道具1使用绑元宝2使用绑元宝和元宝
	}
	response {
		ret				0 : boolean #
		spellsId		1 : integer #法宝id
		spellsNo		2 : integer #法宝编号,锁默认都是0
		num				3 : integer #数量
		perfectNum		4 : integer #完美打造次数
		skillList		5 : *integer #法宝技能列表
	}
}
]]
function server.cs_spellsRes_make(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.role.spellsRes:Make(msg.makeType, msg.autoBuy)
end

--[[
#装备
cs_spellsRes_use 5402 {
	request {
		pos				0 : integer #位置
		spellsId		1 : integer #法宝id
	}
	response {
		ret				0 : boolean #
		pos				1 : integer #位置
		useSpellsNo		2 : integer #使用的法宝编号
		spellsId		3 : integer #法宝id
		spellsNo		4 : integer #如果这个是0就把spellsId法宝删除，如果不是则替换对应spellsId的spellsNo和lock
		useSkillList	5 : *integer #装上去的法宝技能列表
		oldSkillList	6 : *integer #替换下来的法宝技能列表
		lock			7 : integer #锁状态
		num				8 : integer #
	}
}
]]
function server.cs_spellsRes_use(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.role.spellsRes:Use(msg.pos, msg.spellsId)
end

--[[
#升级
cs_spellsRes_up_lv 5404 {
	request {
		pos				0 : integer #位置
		autoBuy			1 : integer #
	}
	response {
		ret				0 : boolean #
		pos				1 : integer #位置
		lv				2 : integer #等级
	}
}
]]
function server.cs_spellsRes_up_lv(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.role.spellsRes:UpLevel(msg.pos, msg.autoBuy)
end

--[[
#分解
cs_spellsRes_smelt 5405 {
	request {
		spellsIdList		0 : *integer #id列表
	}
	response {
		spellsIdList		0 : *integer #id列表
		num					1 : integer #
	}
}
]]
function server.cs_spellsRes_smelt(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.role.spellsRes:Smelt(msg.spellsIdList)
end

--[[
#上锁
cs_spellsRes_lock 5403 {
	request {
		spellsId		1 : integer #法宝id
		lock			0 : integer #0没锁,上锁
	}
	response {
		ret				0 : boolean #
		spellsId		1 : integer #法宝id
		lock			2 : integer #0没锁,上锁
	}
}
]]
function server.cs_spellsRes_lock(socketid, msg)
    local player = server.playerCenter:GetPlayerBySocket(socketid)
    return player.role.spellsRes:Lock(msg.spellsId, msg.lock)
end
